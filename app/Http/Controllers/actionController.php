<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userModel;

class actionController extends Controller
{
    public function store(Request $store)
    {
        $identification = $store->input('identification');
        $firstname = $store->input('firstname');
        $lastname = $store->input('lastname');
        $midname = $store->input('midname');
        $gender = $store->input('gender');
        $birthdate = $store->input('birthdate');

        $storeUser = new userModel;
        $storeUser['identification'] = $identification;
        $storeUser['first_name'] = $firstname;
        $storeUser['last_name'] = $lastname;
        $storeUser['middle_name'] = $midname;
        $storeUser['gender'] = $gender;
        $storeUser['birthdate'] = $birthdate;

        $product = userModel::where('identification', $storeUser)->first();
        if ($product) {
            $response["error"] = true;
            $response["productErr"] = "Product already exists!";
            return response()->json($response);
        } else {
            $storeUser->save();
        }
    }
}
