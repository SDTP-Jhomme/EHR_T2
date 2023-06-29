<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacherModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

class deptController extends Controller
{
    public function storeTeacher(Request $request)
    {
        date_default_timezone_set("Asia/Manila");
        $password = $this->random_password(8);

        $phone_number = $request->input('phone_number');
        $email = $request->input('email');
        $firstname = $request->input('firstname');
        $midname = $request->input('midname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $birthdate = $request->input('birthdate');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";
        $status = "Active";
        $date_now = date("m-d-Y");
        $hashed_password = Hash::make($password);

        $storeTeacher = new teacherModel;
        $storeTeacher['email'] = $email;
        $storeTeacher['firstname'] = $firstname;
        $storeTeacher['midname'] = $midname;
        $storeTeacher['lastname'] = $lastname;
        $storeTeacher['gender'] = $gender;
        $storeTeacher['phone_number'] = $phone_number;
        $storeTeacher['birthdate'] = $birthdate;
        $storeTeacher['status'] = $status;
        $storeTeacher['password'] = $hashed_password;
        $storeTeacher['avatar'] = $avatar;
        $storeTeacher['last_login'] = $date_now;
        $storeTeacher->save();

        if ($storeTeacher) {
            $response = array(
                'email' => $email,
                'password' => $password,
                'storeTeacher' => $storeTeacher,
            );
            $response["error"] = false;
            $response["message"] = "Successfully stores data";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "Failed to store data";

            return response()->json($response, 500);
        }

    }
    public function teacherFetch()
    {
        $user_data = array();
        $response = teacherModel::all();

        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);

                $array_data = array(
                    "id" => $data_row->id,
                    "email" => $data_row->email,
                    "name" => $fullname,
                    "lastname" => $data_row->lastname,
                    "firstname" => $data_row->firstname,
                    "midname" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "gender" => $data_row->gender,
                    "avatar" => $avatar,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                );

                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            $response["message"] = "Table is empty!";
        }

        return response()->json($user_data);
    }
    public function teacherUpdate(Request $update)
    {

        $gender = $update->input('gender');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";
        $update_user = [
            'email' => $update->input('email'),
            'firstname' => $update->input('firstname'),
            'midname' => $update->input('midname'),
            'lastname' => $update->input('lastname'),
            'gender' => $gender,
            'avatar' => $avatar,
            'birthdate' => $update->input('birthdate'),
            'phone_number' => $update->input('phone_number'),

        ];
        $id = $update->input('id');
        $update = teacherModel::where('id', $id)->update($update_user);
        if ($update) {
            // Success
            $response["error"] = false;
            $response["message"] = "Successfully updates data";
            return response()->json($response);
        } else {
            // Failed to update or record not found
            $response["error"] = true;
            $response["message"] = "Failed updates data";
            return response()->json($response, 500);
        }

    }
    public function teacherStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = teacherModel::where('id', $id)->update($update_user);
        if ($update) {
            // Success
            $response["error"] = false;
            $response["message"] = "Successfully updates data";
            return response()->json($response);
        } else {
            // Failed to update or record not found
            $response["error"] = true;
            $response["message"] = "Failed updates data";
            return response()->json($response, 500);
        }

    }
    function getFullName($data_row)
    {
        $fullname = ucfirst($data_row->firstname) . " " . trim(substr(ucfirst($data_row->midname), 0, 1), "undefined") . " " . ucfirst($data_row->lastname);
        return $fullname;
    }

    function getFormattedBirthdate($data_row)
    {
        $db_birthdate = $data_row->birthdate;
        $birthday = substr($db_birthdate, 4, 11);
        $birthdate = date("F d, Y", strtotime($birthday));
        return $birthdate;
    }

    function getAvatarPath($db_avatar)
    {
        $avatar = $db_avatar;
        return $avatar;
    }
    function getAddress($data_row)
    {
        $address = $data_row->street . " " . $data_row->barangay . " " . $data_row->city;
        return $address;
    }
    private function random_password($length = 5)
    {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }

        return $password;
    }
    public function dashboard(Request $request)
    {
        $user = $request->session()->get('teacher_id');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('department/login');
        }

        // Use the $user data as needed in your dashboard logic

        return view('department/dashboard', ['teacher_id' => $user]);
    }

    public function teacherLogin(Request $request)
    {

        $user = $request->session()->get('teacher_id');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return redirect()->route('department-dashboard', ['teacher_id' => $user]);
        // return view('student.dashboard', ['user' => $user]);
    }
    public function deptlogin(Request $request)
    {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("m-d-Y");

        $email = $request->input('email');
        $password = $request->input('password');

        $user = teacherModel::where('email', $email)->first();

        if (empty($email)) {
            $response["error"] = true;
            $response["userErr"] = "Email Address is required!";
            return response()->json($response);
        }
        if (empty($password)) {
            $response["error"] = true;
            $response["passErr"] = "Password is required!";
            return response()->json($response);
        }
        if ($email && $password) {
            if (!$user) {
                $response["error"] = true;
                $response["userErr"] = "Email Address is incorrect!";
                return response()->json($response);
            } else {
                $status = $user->status;

                if ($status == "Inactive") {

                    $response["error"] = true;
                    $response["userErr"] = "User is inactive!";
                    return response()->json($response);
                } else {
                    $hashedPassword = $user->password;
                    if (password_verify($password, $hashedPassword)) {
                        $response["error"] = false;
                        $request->session()->put('teacher_id', $user->id);
                        return response()->json($response);
                    } else {
                        $response["error"] = true;
                        $response["passErr"] = "Password is incorrect!";
                        return response()->json($response);
                    }
                }
            }
        } else {
            $response["error"] = true;
            $response["userErr"] = "Email Address is incorrect!";
            return response()->json($response, 500);
        }
    }

    public function departmentLogout(Request $request)
    {
        Session::forget('teacher_id');

        $response["error"] = false;
        $response["message"] = "Logged out Successfully";
        return response()->json($response);
    }
    public function fetch()
    {

        $user_data = array();
        $studentId = Session::get('teacher_id');

        $fetchAll = teacherModel::all()->where('id', $studentId);
        if ($fetchAll->count() > 0) {
            foreach ($fetchAll as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);

                $array_data = array(
                    "id" => $data_row->id,
                    "email" => $data_row->email,
                    "name" => $fullname,
                    "lastname" => $data_row->lastname,
                    "firstname" => $data_row->firstname,
                    "midname" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "gender" => $data_row->gender,
                    "avatar" => $avatar,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                );

                array_push($user_data, $array_data);
            }
        }
        return response()->json($user_data);
    }
    public function checkPass(Request $check)
    {
        $user_id = $check->input('id');
        $user_record = teacherModel::find($user_id);

        if (!$user_record || !password_verify($check->input("currentPassword"), $user_record->password)) {
            $response["error"] = true;
            $response["message"] = "Password is incorrect!";
        } else {
            $response = true;
        }

        return response()->json($response);
    }
    public function updatePassword(Request $request)
    {
        $user_id = $request->input("id");
        $new_password = $request->input("newPassword");

        $user = teacherModel::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
    public function profile(Request $request)
    {
        $user = $request->session()->get('teacher_id');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('department/login');
        }

        // Use the $user data as needed in your dashboard logic

        return view('department/profile', ['teacher_id' => $user]);
    }
}