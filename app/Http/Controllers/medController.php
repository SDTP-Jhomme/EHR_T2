<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class medController extends Controller
{
    public function cbcPage(){
        return view('admin/medical-records/cbc');
    }
    public function antigenPage(){
        return view('admin/medical-records/antigen');
    }
    public function urinalysisPage(){
        return view('admin/medical-records/urinalysis');
    }
    public function xrayPage(){
        return view('admin/medical-records/xray');
    }
    public function fecalysisPage(){
        return view('admin/medical-records/fecalysis');
    }
    public function vaccinePage(){
        return view('admin/medical-records/vaccine');
    }
}
