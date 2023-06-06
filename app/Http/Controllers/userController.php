<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userModel;

class userController extends Controller
{
    public function cbcForm(){
        return view('admin/forms/cbc');
    }
    public function urinalysisForm(){
        return view('admin/forms/urinalysis');
    }
    public function fecalysisForm(){
        return view('admin/forms/fecal');
    }
    public function xrayForm(){
        return view('admin/forms/xray');
    }
    public function antigenForm(){
        return view('admin/forms/antigen');
    }
    public function vaccineForm(){
        return view('admin/forms/vaccine');
    }
    public function fetchStudent()
    {
        $user_data = array();
        $response = userModel::all();

        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->getFullName($data_row);
                $birthdate = $this->getFormattedBirthdate($data_row);
                $avatar = $this->getAvatarPath($data_row->avatar);
                $address = $this->getAddress($data_row);

                $array_data = array(
                    "id" => $data_row->id,
                    "identification" => $data_row->identification,
                    "name" => $fullname,
                    "last_name" => $data_row->lastname,
                    "first_name" => $data_row->firstname,
                    "middle_name" => $data_row->midname,
                    "birthdate" => $birthdate,
                    "gender" => $data_row->gender,
                    "assets/avatar/" => $avatar,
                    "year" => $data_row->year,
                    "course" => $data_row->course,
                    "civil_status" => $data_row->civil,
                    "citizenship" => $data_row->citizen,
                    "section" => $data_row->section,
                    "address" => $address,
                    "password" => $data_row->password,
                    "status" => $data_row->status,
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
        $avatar = "../assets/$db_avatar";
        return $avatar;
    }
    function getAddress($data_row)
    {
        $address = $data_row->street . " " . $data_row->barangay . " " . $data_row->city;
        return $address;
    }
}
