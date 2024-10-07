<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function loginpage(){

    return view('LoginPage.loginpage');
}


    public function view(){

        return view('Dashboard.dashboard');
    }




}
