<?php

namespace App\Http\Controllers;

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
    public function dashboard()
    {
        $user = session('user');
        if ($user) {
            return redirect(route('admin-dashboard', ['user' => $user]));
        } else {
            return redirect(route('admin-login'));
        }
    }
    public function adminLogin()
    {
        $user = session('user');
        if ($user) {
            return redirect(route('admin-dashboard', ['user' => $user]));
        } else {
            return view('admin/index');
        }
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
        }
    }
}
