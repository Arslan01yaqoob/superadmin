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

        public function add(Request $request)
        {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category_subtitle' => 'required|string|max:500',
                  'onboarding_image' => 'required|file', // validates image and JSON files

            ]);
        
            // Handle file upload
            if ($request->hasFile('onboarding_image')) {
                $file = $request->file('onboarding_image');
            
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $file->move(public_path('assets/onboarding_images'), $filename);
                
                $validatedData['onboarding_image'] = 'assets/onboarding_images/' . $filename;
            }
        
     
            return redirect()->route('onboarding')->with('success', 'Data has been successfully saved.');
        }
        

    public function status(Request $request)
    {

        $ad = Onboarding::find($request->id);
        $ad->status = !$ad->status;
        $ad->save();
        return response()->json(['success' => true]);
    }



}
