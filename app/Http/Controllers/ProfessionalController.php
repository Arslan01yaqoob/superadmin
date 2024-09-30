<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Countries;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfessionalController extends Controller
{

    public function view()
    {
        return view('Professional.professionals');
    }

    public function addpage()
    {
        $country = Countries::where('status', 1)->get();
        $categories= Category::where('status',1)->get();
        return view('Professional.add', compact('country','categories'));
    }

    public function checkUsername(request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:50|alpha_dash',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $username = $request->input('username');
        $exists = Professional::where('username', $username)->exists();
        return response()->json(['available' => !$exists]);
        
    }


    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $email = $request->email;
        $exists = Professional::where('email', $email)->exists();
        return response()->json(['available' => !$exists]);
    }



}
