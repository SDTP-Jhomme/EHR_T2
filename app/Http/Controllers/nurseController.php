<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\nurseModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class nurseController extends Controller
{
    public function cbcPage()
    {
        return view('nurse/medical-records/cbc');
    }
    public function antigenPage()
    {
        return view('nurse/medical-records/antigen');
    }
    public function urinalysisPage()
    {
        return view('nurse/medical-records/urinalysis');
    }
    public function xrayPage()
    {
        return view('nurse/medical-records/xray');
    }
    public function fecalysisPage()
    {
        return view('nurse/medical-records/fecalysis');
    }
    public function vaccinePage()
    {
        return view('nurse/medical-records/vaccine');
    }
    public function nurseprofile()
    {
        return view('nurse/profile');
    }
    // nurse password check and update
    public function checkPass(Request $check)
    {
        $user_id = $check->input('id');
        $user_record = nurseModel::find($user_id);

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

        $user = nurseModel::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
    //nurse login
    public function fetch()
    {

        $user_data = array();
        $nurseId = Session::get('user');

        $fetchAll = nurseModel::all()->where('id', $nurseId);
        if ($fetchAll->count() > 0) {
            foreach ($fetchAll as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);
                $address = $this->getAddress($data_row);

                $array_data = array(
                    "id" => $data_row->id,
                    "identification" => $data_row->identification,
                    "name" => $fullname,
                    "lastname" => $data_row->lastname,
                    "firstname" => $data_row->firstname,
                    "midname" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "gender" => $data_row->gender,
                    "avatar" => '../../' . $avatar,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                );

                array_push($user_data, $array_data);
            }
        }
        return response()->json($user_data);
    }
    public function admission()
    {
        return view('nurse/admission');
    }
    public function dashboard(Request $request)
    {
        $user = $request->session()->get('user');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return view('nurse.dashboard', ['user' => $user]);
    }

    public function nurseLogin(Request $request)
    {

        $user = $request->session()->get('user');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return redirect()->route('nurse-dashboard', ['user' => $user]);
        // return view('nurse.dashboard', ['user' => $user]);
    }
    public function nurse_login(Request $request)
    {
        $identification = $request->input('identification');
        $password = $request->input('password');

        $user = nurseModel::where('identification', $identification)->first();

        if (empty($identification)) {
            $response["error"] = true;
            $response["nurseErr"] = "Identification is required!";
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
                $response["nurseErr"] = "Identification is incorrect!";
                return response()->json($response);
            } else {
                $hashedPassword = $user->password;
                if (password_verify($password, $hashedPassword)) {
                    $response["error"] = false;
                    $request->session()->put('user', $user->id);
                    return response()->json($response);
                } else {
                    $response["error"] = true;
                    $response["passErr"] = "Password is incorrect!";
                    return response()->json($response);
                }
            }
        } else {
            $response["error"] = true;
            $response["nurseErr"] = "Identification is incorrect!";
            return response()->json($response, 500);
        }
    }
    public function nurseLogout(Request $request)
    {
        Session::forget('user');


        $response["error"] = false;
        $response["message"] = "Logged out Successfully";
        return response()->json($response);
    }
    //nurse login END


    // lab-forms
    public function appointments()
    {
        return view('nurse/appointments');
    }


    public function storeNurse(Request $request)
    {
        date_default_timezone_set("Asia/Manila");
        $password = $this->random_password(8);

        $phone_number = $request->input('phone_number');
        $identification = $request->input('identification');
        $firstname = $request->input('firstname');
        $midname = $request->input('midname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $birthdate = $request->input('birthdate');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";
        $status = "Active";
        $street = $request->input('street');
        $brgy = $request->input('brgy');
        $city = $request->input('city');
        $date_now = date("m-d-Y");
        $hashed_password = Hash::make($password);

        $storeNurse = new nurseModel;
        $storeNurse['identification'] = $identification;
        $storeNurse['firstname'] = $firstname;
        $storeNurse['midname'] = $midname;
        $storeNurse['lastname'] = $lastname;
        $storeNurse['gender'] = $gender;
        $storeNurse['phone_number'] = $phone_number;
        $storeNurse['birthdate'] = $birthdate;
        $storeNurse['street'] = $street;
        $storeNurse['brgy'] = $brgy;
        $storeNurse['city'] = $city;
        $storeNurse['status'] = $status;
        $storeNurse['password'] = $hashed_password;
        $storeNurse['avatar'] = $avatar;
        $storeNurse['last_login'] = $date_now;
        $storeNurse->save();

        if ($storeNurse) {
            $response = array(
                'identification' => $identification,
                'password' => $password,
                'storeNurse' => $storeNurse,
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
    public function fetchNurse()
    {
        $user_data = array();
        $response = nurseModel::all();

        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);
                $address = $this->getAddress($data_row);

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
                    "address" => $address,
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
    public function nurseUpdate(Request $update)
    {

        $gender = $update->input('gender');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";
        $update_user = [
            'identification' => $update->input('identification'),
            'firstname' => $update->input('firstname'),
            'midname' => $update->input('midname'),
            'lastname' => $update->input('lastname'),
            'gender' => $gender,
            'avatar' => $avatar,
            'birthdate' => $update->input('birthdate'),
            'phone_number' => $update->input('phone_number'),

        ];
        $id = $update->input('id');
        $update = nurseModel::where('id', $id)->update($update_user);
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
    public function nurseStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = nurseModel::where('id', $id)->update($update_user);
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

}