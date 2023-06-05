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
        $clientInfoData['section'] = "Complete Blood Count";
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
}
