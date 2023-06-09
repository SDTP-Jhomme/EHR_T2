<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\userModel;

class studentController extends Controller
{

    public function fetch()
    {
        $response = userModel::all();
        return response()->json($response);
    }
    public function dashboard(Request $request)
    {
        $user = $request->session()->get('student');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return view('student/index', ['student' => $user]);
    }

    public function studentLogin(Request $request)
    {

        $user = $request->session()->get('student');

        if (!$user) {
            // Redirect to the login page or handle unauthorized access
            return view('index');
        }

        // Use the $user data as needed in your dashboard logic

        return redirect()->route('student-dashboard', ['student' => $user]);
        // return view('student.dashboard', ['user' => $user]);
    }
    public function login(Request $request)
    {
        $identification = $request->input('identification');
        $password = $request->input('password');

        $user = userModel::where('identification', $identification)->first();

        if (empty($identification)) {
            $response["error"] = true;
            $response["studentErr"] = "Identification No. is required!";
            return response()->json($response);
        }
        if (empty($password)) {
            $response["error"] = true;
            $response["passErr"] = "Password is required!";
            return response()->json($response);
        }
        if ($identification && $password) {
            if (!$user) {
                $response["error"] = true;
                $response["studentErr"] = "Identification No. is incorrect!";
                return response()->json($response);
            } else {
                $hashedPassword = $user->password;
                if (password_verify($password, $hashedPassword)) {
                    $response["error"] = false;
                    $request->session()->put('student', $user);
                    return response()->json($response);
                } else {
                    $response["error"] = true;
                    $response["passErr"] = "Password is incorrect!";
                    return response()->json($response);
                }
            }
        } else {
            $response["error"] = true;
            $response["studentErr"] = "Username is incorrect!";
            return response()->json($response, 500);
        }
    }
    public function studentLogout(Request $request)
    {
        Session::forget('student');

        $response["error"] = false;
        $response["message"] = "Logged out Successfully";
        return response()->json($response);
    }
}