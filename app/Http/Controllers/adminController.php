<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\adminModel;

$response = array('error' => false);
class adminController extends Controller
{
    public function fetch()
    {
        $response = adminModel::all();
        return response()->json($response);
    }
    public function admission()
    {
        return view('admin/admission');
    }
    public function dashboard(Request $request)
    {
        $user = $request->session()->get('user');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('admin/index');
        }

        // Use the $user data as needed in your dashboard logic

        return view('admin.dashboard', ['user' => $user]);
    }

    public function adminLogin(Request $request)
    {

        $user = $request->session()->get('user');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('admin/index');
        }

        // Use the $user data as needed in your dashboard logic

        return redirect()->route('admin-dashboard', ['user' => $user]);
        // return view('admin.dashboard', ['user' => $user]);
    }
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = adminModel::where('username', $username)->first();

        if (empty($username)) {
            $response["error"] = true;
            $response["adminErr"] = "Username is required!";
            return response()->json($response);
        }
        if (empty($password)) {
            $response["error"] = true;
            $response["passErr"] = "Password is required!";
            return response()->json($response);
        }
        if ($username && $password) {
            if (!$user) {
                $response["error"] = true;
                $response["adminErr"] = "Username is incorrect!";
                return response()->json($response);
            } else {
                $hashedPassword = $user->password;
                if (password_verify($password, $hashedPassword)) {
                    $response["error"] = false;
                    $request->session()->put('user', $user);
                    return response()->json($response);
                } else {
                    $response["error"] = true;
                    $response["passErr"] = "Password is incorrect!";
                    return response()->json($response);
                }
            }
        }else{
            $response["error"] = true;
            $response["adminErr"] = "Username is incorrect!";
            return response()->json($response , 500);
        }
    }
    public function adminLogout(Request $request)
    {
        Session::forget('user');


        // Perform any other logout-related actions

        // Redirect the user to the desired page after logout
        return redirect()->route('admin-login');
    }

    // lab-forms
    public function cbc()
    {
        return view('admin/forms/cbc');
    }
}
