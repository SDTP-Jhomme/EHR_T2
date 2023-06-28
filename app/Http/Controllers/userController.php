<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userModel;
use App\Models\nurseModel;
use Illuminate\Support\Facades\Hash;
// use Twilio\Rest\Client;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;



class userController extends Controller
{
    public function cbcForm()
    {
        return view('admin/forms/cbc');
    }
    public function urinalysisForm()
    {
        return view('admin/forms/urinalysis');
    }
    public function fecalysisForm()
    {
        return view('admin/forms/fecal');
    }
    public function xrayForm()
    {
        return view('admin/forms/xray');
    }
    public function antigenForm()
    {
        return view('admin/forms/antigen');
    }
    public function vaccineForm()
    {
        return view('admin/forms/vaccine');
    }
    public function storeStudent(Request $request)
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
        $year = $request->input('year');
        $classSection = $request->input('classSection');
        $course = $request->input('course');
        $age = $request->input('age');
        $citizen = $request->input('citizen');
        $civil = $request->input('civil');

        // guardian info
        $guardianFname = $request->input("guardianFname");
        $guardianMname = $request->input('guardianMname');
        $guardianLname = $request->input('guardianLname');
        $contact_person = $guardianFname . " " . $guardianMname . " " . $guardianLname;
        $guardianPhone_number = $request->input('guardianPhone_number');
        $hashed_password = Hash::make($password);


        // Send an SMS notification
        // $to = $phone_number; // Replace with the recipient's phone number
        // $message = 'Use this as your username ' . $identification . ' and this is your Password ' . $password; // Customize the message as needed
        // $twilioSid = env('TWILIO_SID');
        // $twilioToken = env('TWILIO_AUTH_TOKEN');
        // $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        // $twilioClient = new Client($twilioSid, $twilioToken);
        // $twilioClient->messages->create($to, [
        //     'from' => $twilioPhoneNumber,
        //     'body' => $message,
        // ]);
        // Create a new Vonage client instance
        $basic = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new Client($basic);

        // Send an SMS
        $message = $client->sms()->send(
            new SMS($phone_number, env('BRAND_NAME'),  'Use this as your username ' . $identification . ' and this is your Password ' . $password)
        );

        $storeStudent = new userModel;
        $storeStudent['identification'] = $identification;
        $storeStudent['firstname'] = $firstname;
        $storeStudent['midname'] = $midname;
        $storeStudent['lastname'] = $lastname;
        $storeStudent['gender'] = $gender;
        $storeStudent['phone_number'] = $phone_number;
        $storeStudent['birthdate'] = $birthdate;
        $storeStudent['street'] = $street;
        $storeStudent['brgy'] = $brgy;
        $storeStudent['city'] = $city;
        $storeStudent['status'] = $status;
        $storeStudent['password'] = $hashed_password;
        $storeStudent['avatar'] = $avatar;
        $storeStudent['year'] = $year;
        $storeStudent['course'] = $course;
        $storeStudent['classSection'] = $classSection;
        $storeStudent['last_login'] = $date_now;
        $storeStudent['contact_person'] = $contact_person;
        $storeStudent['contact_person_num'] = $guardianPhone_number;
        $storeStudent['age'] = $age;
        $storeStudent['citizen'] = $citizen;
        $storeStudent['civil'] = $civil;
        $storeStudent['med_status'] = "Open";
        $storeStudent->save();

        if ($storeStudent) {
            $response = array(
                'identification' => $identification,
                'password' => $password,
                'storeStudent' => $storeStudent,
                'sms' => $message
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
    public function fetchStudent()
    {
        $user_data = array();
        $response = userModel::all();

        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->getAvatarPath($data_row->avatar);
                $address = $this->getAddress($data_row);
                $yearSect = $this->getYrSect($data_row);
                $contact_person = explode(" ", $data_row->contact_person);


                if (isset($contact_person[0])) {
                    $guardianFname = $contact_person[0];
                } else {
                    $guardianFname = ""; // Handle the case when the first word is not available
                }

                if (isset($contact_person[1])) {
                    $guardianMname = $contact_person[1];
                } else {
                    $guardianMname = ""; // Handle the case when the second word is not available
                }
                if (isset($contact_person[2])) {
                    $guardianLname = $contact_person[2];
                } else {
                    $guardianLname = ""; // Handle the case when the second word is not available
                }

                $array_data = array(
                    "id" => $data_row->id,
                    "identification" => $data_row->identification,
                    "name" => $fullname,
                    "lastname" => $data_row->lastname,
                    "firstname" => $data_row->firstname,
                    "midname" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "guardian" => $data_row->contact_person,
                    "guardianFname" => $guardianFname,
                    "guardianMname" => $guardianMname,
                    "guardianLname" => $guardianLname,
                    "guardianPhone_number" => $data_row->contact_person_num,
                    "gender" => $data_row->gender,
                    "avatar" => '../../' . $avatar,
                    "year" => $data_row->year,
                    "course" => $data_row->course,
                    "civil" => $data_row->civil,
                    "citizen" => $data_row->citizen,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                    "classSection" => $data_row->classSection,
                    'yearandsection' => $yearSect,
                    "age" => $data_row->age,
                    "medStatus" => $data_row->med_status,
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