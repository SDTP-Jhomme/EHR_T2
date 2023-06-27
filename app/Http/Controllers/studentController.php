<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\userModel;
use Illuminate\Support\Facades\Auth;

class studentController extends Controller
{
    public function studentProfile()
    {
        return view('student/profile');
    }
    public function fetch()
    {

        $user_data = array();
        $studentId = Session::get('student_id');

        $fetchAll = userModel::all()->where('id', $studentId);
        if ($fetchAll->count() > 0) {
            foreach ($fetchAll as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);
                $address = $this->getAddress($data_row);
                $yearSect = $this->getYrSect($data_row);

                $array_data = array(
                    "id" => $data_row->id,
                    "identification" => $data_row->identification,
                    "name" => $fullname,
                    "lastname" => $data_row->lastname,
                    "firstname" => $data_row->firstname,
                    "midname" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "gender" => $data_row->gender,
                    "avatar" => $avatar,
                    "year" => $data_row->year,
                    "course" => $data_row->course,
                    "civil" => $data_row->civil,
                    "citizenship" => $data_row->citizen,
                    // "section" => $data_row->section,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                    "classSection" => $data_row->classSection,
                    "next_appointment" => $data_row->next_appointment,
                    'yearandsection' => $yearSect,
                    'age' => $data_row->age
                );

                array_push($user_data, $array_data);
            }
        }
        return response()->json($user_data);
    }
    public function updateAvatar(Request $update)
    {
        $user_id = $update->input('id');
        $file = $update->input('file');

        $update = userModel::where('id', $user_id)->update($file);

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
    public function checkPass(Request $check)
    {
        $user_id = $check->input('id');
        $user_record = userModel::find($user_id);

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

        $user = userModel::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
    public function dashboard(Request $request)
    {
        $user = $request->session()->get('student_id');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return view('student/index', ['student_id' => $user]);
    }

    public function studentLogin(Request $request)
    {

        $user = $request->session()->get('student_id');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return redirect()->route('student-dashboard', ['student_id' => $user]);
        // return view('student.dashboard', ['user' => $user]);
    }
    public function login(Request $request)
    {
        // $identification = $request->input('identification');
        // $password = $request->input('password');

        // $user = userModel::where('identification', $identification)->first();

        // if (empty($identification)) {
        //     $response["error"] = true;
        //     $response["studentErr"] = "Identification is required!";
        //     return response()->json($response);
        // }
        // if (empty($password)) {
        //     $response["error"] = true;
        //     $response["passErr"] = "Password is required!";
        //     return response()->json($response);
        // }
        // if ($identification && $password) {
        //     if (!$user) {
        //         $response["error"] = true;
        //         $response["studentErr"] = "identification is incorrect!";
        //         return response()->json($response);
        //     } else {
        //         $hashedPassword = $user->password;
        //         if (password_verify($password, $hashedPassword)) {
        //             $response["error"] = false;
        //             $request->session()->put('student_id', $user->id);
        //             return response()->json($response);
        //         } else {
        //             $response["error"] = true;
        //             $response["passErr"] = "Password is incorrect!";
        //             return response()->json($response);
        //         }
        //     }
        // }else{
        //     $response["error"] = true;
        //     $response["studentErr"] = "identification is incorrect!";
        //     return response()->json($response , 500);
        // }
        date_default_timezone_set("Asia/Manila");
        $date_now = date("m-d-Y");

        $identification = $request->input('identification');
        $password = $request->input('password');

        $user = userModel::where('identification', $identification)->first();

        if (empty($identification)) {
            $response["error"] = true;
            $response["studentErr"] = "Identification No. is required!";
            return response()->json($response);
        }
        if (empty($password)) {
            $response["error"] = true;
            $response["passErr"] = "Password is required!";
            return response()->json($response);
        }
        if ($identification && $password) {
            if (!$user) {
                $response["error"] = true;
                $response["studentErr"] = "Identification No. is incorrect!";
                return response()->json($response);
            } else {
                $status = $user->status;

                if ($status == "Inactive") {

                    $response["error"] = true;
                    $response["studentErr"] = "User is inactive!";
                    return response()->json($response);
                } else {
                    $hashedPassword = $user->password;
                    if (password_verify($password, $hashedPassword)) {
                        $response["error"] = false;
                        $request->session()->put('student_id', $user->id);
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
            $response["studentErr"] = "Username is incorrect!";
            return response()->json($response, 500);
        }
    }
    public function studentLogout(Request $request)
    {
        Session::forget('student_id');

        $response["error"] = false;
        $response["message"] = "Logged out Successfully";
        return response()->json($response);
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
    function getYrSect($data_row)
    {
        $yearSect = $data_row->year . " - Section " . $data_row->classSection;
        return $yearSect;
    }
    public function loginAll(Request $request)
    {

        return view('login');
    }
}