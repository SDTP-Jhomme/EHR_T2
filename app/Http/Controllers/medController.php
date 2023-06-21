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

    public function cbcFile(){
        return view('department/medical-records/cbc');
    }
    public function antigenFile(){
        return view('department/medical-records/antigen');
    }
    public function urinalysisFile(){
        return view('department/medical-records/urinalysis');
    }
    public function xrayFile(){
        return view('department/medical-records/xray');
    }
    public function fecalysisFile(){
        return view('department/medical-records/fecalysis');
    }
    public function vaccineFile(){
        return view('department/medical-records/vaccine');
    }

    public function cbcForms(){
        return view('nurse/medical-records/cbc');
    }
    public function antigenForms(){
        return view('nurse/medical-records/antigen');
    }
    public function urinalysisForms(){
        return view('nurse/medical-records/urinalysis');
    }
    public function xrayForms(){
        return view('nurse/medical-records/xray');
    }
    public function fecalysisForms(){
        return view('nurse/medical-records/fecalysis');
    }
    public function vaccineForms(){
        return view('nurse/medical-records/vaccine');
    }
}
