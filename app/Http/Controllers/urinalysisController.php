<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\urinalysisModel;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class urinalysisController extends Controller
{
    public function storeUrinalysis(Request $request)
    {
        $password = $this->random_password(8);

        $gender = $request->input('gender');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";

        $hashed_password = Hash::make($password);

        $clientInfoData = $request->all();
        $clientInfoData['password'] = $hashed_password;
        $clientInfoData['avatar'] = $avatar;
        $clientInfoData['section'] = "Urinalysis";
        $clientInfoData['status'] = "Active";
        $phoneNumber = $clientInfoData['phone_number'];
        $identification = $clientInfoData['identification'];
        $clientInfo = userModel::create($clientInfoData);

        // Send an SMS notification
        $to = $phoneNumber; // Replace with the recipient's phone number
        $message = 'Use this as your username ' . $identification . ' and this is your Password ' . $password; // Customize the message as needed
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $twilioClient = new Client($twilioSid, $twilioToken);
        $twilioClient->messages->create($to, [
            'from' => $twilioPhoneNumber,
            'body' => $message,
        ]);

        $urinalysisModel = [
            'age' => $request->input('age'),
            'requestDate' => $request->input('requestDate'),
            'color' => $request->input('color'),
            'transparency' => $request->input('transparency'),
            'gravity' => $request->input('gravity'),
            'ph' => $request->input('ph'),
            'sugar' => $request->input('sugar'),
            'protein' => $request->input('protein'),
            'pregnancy' => $request->input('pregnancy'),
            'pus' => $request->input('pus'),
            'rbc' => $request->input('rbc'),
            'cast' => $request->input('cast'),
            'urates' => $request->input('urates'),
            'uric' => $request->input('uric'),
            'cal' => $request->input('cal'),
            'epith' => $request->input('epith'),
            'mucus' => $request->input('mucus'),
            'otherOthers' => $request->input('otherOthers'),
            'pathologist' => $request->input('pathologist'),
            'technologist' => $request->input('technologist'),
            'section' => "Urinalysis",
        ];

        $urinalysis = urinalysisModel::create(array_merge($urinalysisModel, ['student_id' => $clientInfo->id]));

        if ($clientInfo && $urinalysis) {
            $response = array(
                'password' => $password,
                'clientInfo' => $clientInfo,
                'urinalysis' => $urinalysis,
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
    public function fetchUrinalysis(){
        $user_data = array();
        $response = userModel::join('urinalysis_table', 'client_info.id', '=', 'urinalysis_table.student_id')
        ->select('client_info.*', 'urinalysis_table.*') // Select all columns from 'client_info' and 'cbc' tables
        ->get();
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
                    "requestDate" => $data_row->requestDate,
                    "color" => $data_row->color,
                    "transparency" => $data_row->transparency,
                    "gravity" => $data_row->gravity,
                    "ph" => $data_row->ph,
                    "sugar" => $data_row->sugar,
                    "protein" => $data_row->protein,
                    "pregnancy" => $data_row->pregnancy,
                    "pus" => $data_row->pus,
                    "rbc" => $data_row->rbc,
                    "cast" => $data_row->cast,
                    "urates" => $data_row->urates,
                    "uric" => $data_row->uric,
                    "cal" => $data_row->cal,
                    "epith" => $data_row->epith,
                    "mucus" => $data_row->mucus,
                    "otherOthers" => $data_row->otherOthers,
                    "pathologist" => $data_row->pathologist,
                    "technologist" => $data_row->technologist
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
                $response["message"] = "Table is empty!";
                return response()->json($user_data,500);
            }
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
}