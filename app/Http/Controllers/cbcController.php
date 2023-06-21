<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cbcModel;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

$response = array('error' => false);
class cbcController extends Controller
{
    public function storeCbc(Request $request)
    {
        $password = $this->random_password(8);

        $gender = $request->input('gender');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";

        $hashed_password = Hash::make($password);

        $clientInfoData = $request->all();
        $clientInfoData['password'] = $hashed_password;
        $clientInfoData['avatar'] = $avatar;
        $clientInfoData['section'] = "Complete Blood Count";
        $clientInfoData['status'] = "Active";
        $phoneNumber = $clientInfoData['phone_number'];
        $identification = $clientInfoData['identification'];
        $clientInfo = userModel::create($clientInfoData);

        // Send an SMS notification
        $to = $phoneNumber; // Replace with the recipient's phone number
        $message = 'Use this as your username '. $identification.' and this is your Password '. $password; // Customize the message as needed
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $twilioClient = new Client($twilioSid, $twilioToken);
        $twilioClient->messages->create($to, [
            'from' => $twilioPhoneNumber,
            'body' => $message,
        ]);

        $cbcData = [
            'age' => $request->input('age'),
            'hemoglobin' => $request->input('hemoglobin'),
            'hematocrit' => $request->input('hematocrit'),
            'wbc' => $request->input('wbc'),
            'rbc' => $request->input('rbc'),
            'mcv' => $request->input('mcv'),
            'mch' => $request->input('mch'),
            'mchc' => $request->input('mchc'),
            'platelet' => $request->input('platelet'),
            'section' => "Complete Blood Count",
        ];

        $cbc = cbcModel::create(array_merge($cbcData, ['student_id' => $clientInfo->id]));

        if ($clientInfo && $cbc) {
            $response = array(
                'password' => $password,
                'clientInfo' => $clientInfo,
                'cbc' => $cbc,
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
        $avatar = "../assets/$db_avatar";
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
    function fetchFullName($data_row)
    {
        $fullname = ucfirst($data_row->firstname) . " " . trim(substr(ucfirst($data_row->midname), 0, 1), "undefined") . " " . ucfirst($data_row->lastname);
        return $fullname;
    }

    function fetchFormattedBirthdate($data_row)
    {
        $db_birthdate = $data_row->birthdate;
        $birthday = substr($db_birthdate, 4, 11);
        $birthdate = date("F d, Y", strtotime($birthday));
        return $birthdate;
    }

    function fetchAvatarPath($db_avatar)
    {
        $avatar = $db_avatar;
        return $avatar;
    }
    function fetchAddress($data_row)
    {
        $address = $data_row->street . " " . $data_row->barangay . " " . $data_row->city;
        return $address;
    }
    public function fetchCbc(){
        $user_data = array();
        $response = userModel::join('cbc_table', 'client_info.id', '=', 'cbc_table.student_id')
        ->select('client_info.*', 'cbc_table.*') // Select all columns from 'client_info' and 'cbc' tables
        ->get();;
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->fetchFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->fetchAvatarPath($data_row->avatar);
                $address = $this->fetchAddress($data_row);

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
                    "civil_status" => $data_row->civil,
                    "citizenship" => $data_row->citizen,
                    "section" => $data_row->section,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                    "classSection" => $data_row->classSection,
                    "age" => $data_row->age,
                    "hemoglobin" => $data_row->hemoglobin,
                    "hematocrit" => $data_row->hematocrit,
                    "wbc" => $data_row->wbc,
                    "rbc" => $data_row->rbc,
                    "mcv" => $data_row->mcv,
                    "mch" => $data_row->mch,
                    "mchc" => $data_row->mchc,
                    "platelet" => $data_row->platelet,
                    "student_id" => $data_row->student_id,
                );
                

                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            $response["message"] = "Table is empty!";
        }
        if($user_data){
            $response["error"] = false;
            return response()->json($user_data);
        }else{
            
            $response["error"] = true;
            return response()->json($user_data,500);
        }
    }

    //update cbc
    public function cbcUpdate(Request $update)
    {
        $update_user = [
            'hemoglobin' => $update->input('hemoglobin'),
            'hematocrit' => $update->input('hematocrit'),
            'wbc' => $update->input('wbc'),
            'rbc' => $update->input('rbc'),
            'mcv' => $update->input('mcv'),
            'mch' => $update->input('mch'),
            'mchc' => $update->input('mchc'),
            'platelet' => $update->input('platelet'),

        ];
        $id = $update->input('id');
        $update = cbcModel::where('id', $id)->update($update_user);
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

    public function cbcStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = cbcModel::where('id', $id)->update($update_user);
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
}