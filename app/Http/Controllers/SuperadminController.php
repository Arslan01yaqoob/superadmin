<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{

    public function loginpage()
    {
        return view('LoginPage.loginpage');
    }


    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }


    public function logout()
    {

        Auth::logout();
        return redirect()->route('loginpage');
    }
}
