<?php

namespace App\Http\Controllers;

use App\Models\userModel;
use App\Models\cbcModel;
use App\Models\antigenModel;
use App\Models\fecaModel;
use App\Models\urinalysisModel;
use App\Models\vaxxModel;
use App\Models\xrayModel;
use App\Models\reqModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class fetch_userRecord extends Controller
{
    public function fetch_Cbc()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = cbcModel::join('client_info', 'cbc_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'cbc_table.*')
            ->where('cbc_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
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
    public function fetch_Antigen()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = antigenModel::join('client_info', 'antigen_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'antigen_table.*')
            ->where('antigen_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
                );


                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
    public function fetch_Urinalysis()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = urinalysisModel::join('client_info', 'urinalysis_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'urinalysis_table.*')
            ->where('urinalysis_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
                );

                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
    public function fetch_Xray()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = xrayModel::join('client_info', 'xray_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'xray_table.*')
            ->where('xray_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
                );


                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
    public function fetch_Fecalysis()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = fecaModel::join('client_info', 'fecalysis_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'fecalysis_table.*')
            ->where('fecalysis_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
                );

                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
    public function fetch_Appointment()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = reqModel::join('client_info', 'request_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'request_table.*')
            ->where('request_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->fetchFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->fetchAvatarPath($data_row->avatar);
                $address = $this->fetchAddress($data_row);
                $yearSect = $this->getYrSect($data_row);
                $created_at = date("F d, Y", strtotime($data_row->created_at));
                $request_date = date("F d, Y - h:i A", strtotime($data_row->request_date));
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
                    "med_status" => $data_row->med_status,
                    "phone_number" => $data_row->phone_number,
                    "classSection" => $data_row->classSection,
                    "request_date" => $request_date,
                    "student_id" => $data_row->student_id,
                    'yearandsection' => $yearSect,
                    "created_at" => $created_at,
                );


                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
        }
    }
    public function fetch_Vaccine()
    {
        $user_data = array();
        $studentId = Session::get('student_id');
        $response = vaxxModel::join('client_info', 'vaccine_table.student_id', '=', 'client_info.id')
            ->select('client_info.*', 'vaccine_table.*')
            ->where('vaccine_table.student_id', $studentId)
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $array_data = array(
                    "id" => $data_row->id,
                    "age" => $data_row->age,
                    "result" => '../../assets/' . $data_row->result,
                    "student_id" => $data_row->student_id,
                    "dataCreated" => date("F d, Y", strtotime($data_row->created_at)),
                    "section" => $data_row->section,
                );


                array_push($user_data, $array_data);
            }
        } else {
            $response = array();
            $response["error"] = true;
            return response()->json($user_data, 500);
        }
        if ($user_data) {
            $response["error"] = false;
            return response()->json($user_data);
        } else {

            $response["error"] = true;
            return response()->json($user_data, 500);
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
    function getYrSect($data_row)
    {
        $yearSect = $data_row->year . " - Section " . $data_row->classSection;
        return $yearSect;
    }
}