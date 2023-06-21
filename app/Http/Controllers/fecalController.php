<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fecaModel;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

$response = array('error' => false);

class fecalController extends Controller
{
    public function storeFecalysis(Request $request)
    {
        $password = $this->random_password(8);

        $gender = $request->input('gender');
        $avatar = ($gender == 'Male') ? "assets/avatar/default.png" : "assets/avatar/default-woman.png";

        $hashed_password = Hash::make($password);

        $clientInfoData = $request->all();
        $clientInfoData['password'] = $hashed_password;
        $clientInfoData['avatar'] = $avatar;
        $clientInfoData['section'] = "Fecalysis";
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

        $fecalysisData = [
            'age' => $request->input('age'),
            'requestBy' => $request->input('requestBy'),
            'requestDate' => $request->input('requestDate'),
            'color' => $request->input('color'),
            'consistency' => $request->input('consistency'),
            'occult' => $request->input('occult'),
            'otherOccult' => $request->input('otherOccult'),
            'pus' => $request->input('pus'),
            'rbc' => $request->input('rbc'),
            'fat' => $request->input('fat'),
            'ova' => $request->input('ova'),
            'larva' => $request->input('larva'),
            'adult' => $request->input('adult'),
            'cyst' => $request->input('cyst'),
            'trophozoites' => $request->input('trophozoites'),
            'otherTrophozoites' => $request->input('otherTrophozoites'),
            'remarks' => $request->input('remarks'),
            'pathologist' => $request->input('pathologist'),
            'technologist' => $request->input('technologist'),
            'section' => "Complete Blood Count",
        ];

        $fecalysis = fecaModel::create(array_merge($fecalysisData, ['student_id' => $clientInfo->id]));

        if ($clientInfo && $fecalysis) {
            $response = array(
                'password' => $password,
                'clientInfo' => $clientInfo,
                'fecalysis' => $fecalysis,
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
    public function fetchFecalysis(){
        $user_data = array();
        $response = userModel::join('fecalysis_table', 'client_info.id', '=', 'fecalysis_table.student_id')
        ->select('client_info.*', 'fecalysis_table.*') // Select all columns from 'client_info' and 'cbc' tables
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
                    "requestBy" => $data_row->requestBy,
                    "requestDate" => $data_row->requestDate,
                    "color" => $data_row->color,
                    "consistency" => $data_row->consistency,
                    "occult" => $data_row->occult,
                    "otherOccult" => $data_row->otherOccult,
                    "pus" => $data_row->pus,
                    "rbc" => $data_row->rbc,
                    "fat" => $data_row->fat,
                    "ova" => $data_row->ova,
                    "larva" => $data_row->larva,
                    "adult" => $data_row->adult,
                    "cyst" => $data_row->cyst,
                    "trophozoites" => $data_row->trophozoites,
                    "otherTrophozoites" => $data_row->otherTrophozoites,
                    "remarks" => $data_row->remarks,
                    "pathologist" => $data_row->pathologist,
                    "technologist" => $data_row->technologist,
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

    // update fecal
    public function fecalUpdate(Request $update)
    {
        $update_user = [
            // 'sampleDate' => $update->input('sampleDate'),
            // 'result' => $update->input('result'),
            "requestBy" => $update->input('requestBy'),
            "color" => $update->input('color'),
            "consistency" => $update->input('consistency'),
            "occult" => $update->input('occult'),
            "otherOccult" => $update->input('otherOccult'),
            "pus" => $update->input('pus'),
            "rbc" => $update->input('rbc'),
            "fat" => $update->input('fat'),
            "ova" => $update->input('ova'),
            "larva" => $update->input('larva'),
            "adult" => $update->input('adult'),
            "cyst" => $update->input('cyst'),
            "trophozoites" => $update->input('trophozoites'),
            "otherTrophozoites" => $update->input('otherTrophozoites'),
            "remarks" => $update->input('remarks'),
            "pathologist" => $update->input('pathologist'),
            "technologist" => $update->input('technologist'),
        ];
        $id = $update->input('id');
        $update = fecaModel::where('id', $id)->update($update_user);
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

    public function fecalStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = fecaModel::where('id', $id)->update($update_user);
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
