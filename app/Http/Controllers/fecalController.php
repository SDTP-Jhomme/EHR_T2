<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fecaModel;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use Illuminate\Support\Str;

$response = array('error' => false);

class fecalController extends Controller
{
    public function storeFecalysis(Request $request)
    {
        $student_id = $request->input('student_id');
        $med_status = $request->input('med_status');
        $section = "Fecalysis";

        $storeStudent = null; // Initialize the variable

        // Check if files were uploaded
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            // Loop through each uploaded file
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $randomName = Str::random(20) . '.' . $extension;
                $file->move(public_path('/assets/results/'), $randomName);

                // Store the file information in the database
                $storeStudent = new fecaModel;
                $storeStudent->student_id = $student_id;
                $storeStudent->section = $section;
                $storeStudent->result = 'results/' . $randomName;
                $storeStudent->save();
            }

            // Update the medical status
            $updateMed = userModel::where('id', $student_id)->update(['med_status' => $med_status]);

            $response = [
                'storeStudent' => $storeStudent,
                'updateMed' => $updateMed,
                'error' => false,
                'message' => 'Successfully stored data',
            ];

            return response()->json($response);
        } else {
            $response = [
                'error' => true,
                'message' => 'No files were uploaded',
            ];

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
        $avatar = "../../assets/$db_avatar";
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
        $response = fecaModel::join('client_info', 'fecalysis_table.student_id', '=', 'client_info.id')
        ->select('client_info.*', 'fecalysis_table.*') // Select all columns from 'client_info' and 'cbc' tables
        ->get();
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
                    "avatar" => '../../' . $data_row->avatar,
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
                    "result" => '../../assets/'.$data_row->result,
                    "student_id" => $data_row->student_id,
                    "guardian" => $data_row->contact_person,
                    "guardianFname" => $guardianFname,
                    "guardianMname" => $guardianMname,
                    "guardianLname" => $guardianLname,
                    "guardianPhone_number" => $data_row->contact_person_num,
                    "medStatus" => $data_row->med_status,
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
