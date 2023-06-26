<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reqModel;
use App\Models\userModel;
use Carbon\Carbon;


class requestController extends Controller
{
    public function storeReq(Request $request)
    {
        date_default_timezone_set("Asia/Manila");
        $user_id = $request->input('student_id');
        $section = $request->input('section');
        $request_date = $request->input('request_date');
        $storeRequest = new reqModel;
        $storeRequest['med_status'] = "Pending";
        $storeRequest['student_id'] = $user_id;
        $storeRequest['section'] = $section;
        $storeRequest['request_date'] = $request_date;
        $storeRequest->save();
        
        if( $storeRequest){
            $response = array(
                'storeRequest' => $storeRequest,
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

    public function countRequest()
    {
        $count = reqModel::where('med_status', 'Pending')->count();

        return response()->json($count);
    }

    public function approvedStatus(Request $update)
    {
        $update_user = [
            'med_status' => $update->input('med_status'),

        ];
        $id = $update->input('id');
        $update = reqModel::where('id', $id)->update($update_user);
        if ($update) {
            // Success
            $response["error"] = false;
            $response["message"] = "Appointment approved successfully";
            return response()->json($response);
        } else {
            // Failed to update or record not found
            $response["error"] = true;
            $response["message"] = "Appointment failed approved";
            return response()->json($response, 500);
        }
    }
    public function rejectedStatus(Request $update)
    {
        $update_user = [
            'med_status' => $update->input('med_status'),

        ];
        $id = $update->input('id');
        $update = reqModel::where('id', $id)->update($update_user);
        if ($update) {
            // Success
            $response["error"] = false;
            $response["message"] = "Appointment declined successfully";
            return response()->json($response);
        } else {
            // Failed to update or record not found
            $response["error"] = true;
            $response["message"] = "Appointment failed approved";
            return response()->json($response, 500);
        }
    }

    public function fetchRequest()
    {
        $user_data = array();

        $response = userModel::join('request_table', 'client_info.id', '=', 'request_table.student_id')
            ->select('client_info.*', 'request_table.*') // Select all columns from 'client_info' and 'cbc' tables
            ->get();
        if ($response->count() > 0) {
            foreach ($response as $data_row) {
                $fullname = $this->fetchFullName($data_row);
                $birthdate = date("F d, Y", strtotime($data_row->birthdate));
                $avatar = $this->fetchAvatarPath($data_row->avatar);
                $address = $this->fetchAddress($data_row);
                $yearSect = $this->getYrSect($data_row);
                $created_at = date("F d, Y", strtotime($data_row->created_at));
                $request_date = $data_row->request_date;

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

    public function updateStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = reqModel::where('id', $id)->update($update_user);
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