<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nurseModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class nurseController extends Controller
{
    
    public function storeNurse(Request $request)
    {
        $password = $this->random_password(8);

        $phone_number = $request->input('phone_number');
        $identification = $request->input('identification');
        $firstname = $request->input('firstname');
        $midname = $request->input('midname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $birthdate = $request->input('birthdate');
        $avatar = ($gender == 'Male') ? "storage/assets/avatar/default.png" : "storage/assets/avatar/default-woman.png";
        $status = "Active";
        $street = $request->input('street');
        $brgy = $request->input('brgy');
        $city = $request->input('city');
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
        $storeNurse->save();

        if( $storeNurse){
            $response = array(
                'identification' => $identification,
                'password' => $password,
                'storeNurse' => $storeNurse,
            );
            $response["error"] = false;
            $response["message"] = "Successfully stores data";
            return response()->json($response);
        }else {
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
    public function nurseUpdate(Request $update){
        $update_user =[
            'identification' => $update->input('identification'),
            'firstname' => $update->input('firstname'),
            'midname' => $update->input('midname'),
            'lastname' => $update->input('lastname'),
            'gender' => $update->input('gender'),
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
            return response()->json($response , 500);
        }
        
    }
    public function nurseStatus(Request $update){
        $update_user =[
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
            return response()->json($response , 500);
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
