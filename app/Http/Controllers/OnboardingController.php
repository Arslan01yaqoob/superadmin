<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Onboarding;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function view(){

          $ads= Onboarding::get() ;

        return view('onboarding.onboardingads',compact('ads'));

    }


public function addpage(){

    return view('onboarding.add');

}


    public function status(Request $request)
    {

        $ad = Onboarding::find($request->id);
        $ad->status = !$ad->status;
        $ad->save();
        return response()->json(['success' => true]);
    }



}
