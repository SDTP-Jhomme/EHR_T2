<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userModel;
use App\Models\cbcModel;
use App\Models\fecaModel;
use App\Models\antigenModel;
use App\Models\vaxxModel;
use App\Models\urinalysisModel;
use App\Models\xrayModel;

class actionController extends Controller
{
    public function nurse()
    {
        return view('admin/registration/nurse');
    }
    public function teacher()
    {
        return view('admin/registration/teacher');
    }
    public function studentUpdate(Request $update)
    {
        $guardianFname= $update->input('guardianFname');
        $guardianMname= $update->input('guardianMname');
        $guardianLname= $update->input('guardianLname');
        $contact_person = $guardianFname . " " . $guardianMname . " " . $guardianLname;
        $update_user = [
            'identification' => $update->input('identification'),
            'year' => $update->input('year'),
            'classSection' => $update->input('classSection'),
            'firstname' => $update->input('firstname'),
            'midname' => $update->input('midname'),
            'lastname' => $update->input('lastname'),
            'gender' => $update->input('gender'),
            'birthdate' => $update->input('birthdate'),
            'phone_number' => $update->input('phone_number'),
            'contact_person' => $contact_person,
            'contact_person_num' => $update->input('guardianPhone_number'),
            'age' => $update->input('age'),
            'citizen' => $update->input('citizen'),
            'civil' => $update->input('civil'),
        ];
        $id = $update->input('id');
        $update = userModel::where('id', $id)->update($update_user);
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
    public function studentStatus(Request $update)
    {
        $update_user = [
            'status' => $update->input('status'),

        ];
        $id = $update->input('id');
        $update = userModel::where('id', $id)->update($update_user);
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
    public function countXray()
    {
        $count = xrayModel::count();

        return response()->json($count);
    }
    public function countfecal()
    {
        $count = fecaModel::count();

        return response()->json($count);
    }
    public function countUrine()
    {
        $count = urinalysisModel::count();

        return response()->json($count);
    }
    public function countVaccine()
    {
        $count = vaxxModel::count();

        return response()->json($count);
    }
    public function countAntigen()
    {
        $count = antigenModel::count();

        return response()->json($count);
    }
    public function countCbc()
    {
        $count = cbcModel::count();

        return response()->json($count);
    }
    public function getDataByMonth()
    {
        $months = userModel::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->get();
        $response =[
            'total' => $months
        ];

        if ($response) {
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
    public function getChartData()
    {
        $cbcData = cbcModel::all();
        $antigenData = antigenModel::all();
        $fecaData = fecaModel::all();
        $urinalysisData = urinalysisModel::all();
        $vaxxData = vaxxModel::all();
        $xrayData = xrayModel::all();

        $data = [
            'labels' => ['Complete Blood Count', 'Heppa B Antigen', 'Fecalysis', 'Urinalysis', 'Heppa B Vaccine', 'Chest X-ray (PA)'],
            'values' => [
                $cbcData->count(),
                $antigenData->count(),
                $fecaData->count(),
                $urinalysisData->count(),
                $vaxxData->count(),
                $xrayData->count()
            ],
            'colors' => [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        ];

        return response()->json($data);
    }
}