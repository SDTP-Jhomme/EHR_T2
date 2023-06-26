<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cbcModel;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use Illuminate\Support\Str;

$response = array('error' => false);
class cbcController extends Controller
{
    public function storeCbc(Request $request)
    {
        $student_id = $request->input('student_id');
        $med_status = $request->input('med_status');
        $section = "Complete Blood Count";
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();
            $randomName = Str::random(20) . '.' . $extension;
            $image->move(public_path('storage/results'), $randomName);

            $storeStudent = new cbcModel;
            $storeStudent->student_id = $student_id;
            $storeStudent->section = $section;
            $storeStudent->result = 'results/' . $randomName;
            $storeStudent->save();
            $updateMed = userModel::where('med_status', $med_status)->update(['med_status' => $med_status]);
        }

        if ($storeStudent) {
            $response = array(
                'storeStudent' => $storeStudent,
                'updateMed' => $updateMed,
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
    public function fetchCbc()
    {
        $user_data = array();
        $response = userModel::join('cbc_table', 'client_info.id', '=', 'cbc_table.student_id')
            ->select('client_info.*', 'cbc_table.*') // Select all columns from 'client_info' and 'cbc' tables
            ->get();
        ;
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->fetchFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->fetchAvatarPath($data_row->avatar);
                $address = $this->fetchAddress($data_row);
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
                    "gender" => $data_row->gender,
                    "avatar" => $avatar,
                    "year" => $data_row->year,
                    "course" => $data_row->course,
                    "civil" => $data_row->civil,
                    "citizen" => $data_row->citizen,
                    "section" => $data_row->section,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
                    "phone_number" => $data_row->phone_number,
                    "classSection" => $data_row->classSection,
                    "age" => $data_row->age,
                    "result" => '../../storage/'.$data_row->result,
                    "student_id" => $data_row->student_id,
                    "guardian" => $data_row->contact_person,
                    "guardianFname" => $guardianFname,
                    "guardianMname" => $guardianMname,
                    "guardianLname" => $guardianLname,
                    "guardianPhone_number" => $data_row->contact_person_num,
                );


                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            $response["message"] = "Table is empty!";
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
}