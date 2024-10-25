<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Onboarding;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function view()
    {

        return  $ads = Onboarding::get();
      
        
    }

    public function add(Request $request)
{
    $onboardingCount = Onboarding::count();

    if ($onboardingCount >= 3) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to add onboarding item. Only three advertisements are allowed at a time.'
        ], 400);
    }

    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'required|string|max:500',
        'onboarding_image' => 'required|file', // validates image and JSON file
    ]);

    $file = $request->file('onboarding_image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('assets/onboarding_images'), $filename);
    $imagepath = 'assets/onboarding_images/' . $filename;

    $onboarding = new Onboarding;
    $onboarding->image_url = $imagepath;
    $onboarding->title = $request->title;
    $onboarding->subtitle = $request->subtitle;

    $onboarding->save();

    return response()->json([
        'success' => true,
        'message' => 'Onboarding item added successfully!'
    ]);
}


    public function status(Request $request)
    {
        $ad = Onboarding::find($request->id);
        $ad->status = !$ad->status;
        $ad->save();
        return response()->json(['success' => true]);
    }
    public function destroy(Request $request)
    {
        $onboarding = Onboarding::findorFail($request->addid);


        $filePath = public_path($onboarding->image_url);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $onboarding->delete();

        return response()->json(['success' => true]);

    }

    public function updatepage($id)
    {

        $onboarding = Onboarding::findorFail($id);
        return view('onboarding.eidt', compact('onboarding'));
    }

    public function update(Request $request, $id)
{

    $onboarding = Onboarding::findorFail($id);

    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'category_subtitle' => 'required|string|max:500',
        'onboarding_image' => 'nullable|file', // image is optional
    ]);

    // Check if a new image is uploaded
    if ($request->hasFile('onboarding_image')) {
        // Unlink the old image if exists
        if ($onboarding->image_url && file_exists(public_path($onboarding->image_url))) {
            unlink(public_path($onboarding->image_url));
        }

        // Store the new image
        $file = $request->file('onboarding_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/onboarding_images'), $filename);
        $imagepath = 'assets/onboarding_images/' . $filename;

        // Update the image URL in the database
        $onboarding->image_url = $imagepath;
    }

    // Update other fields
    $onboarding->title = $request->title;
    $onboarding->subtitle = $request->category_subtitle;

    if ($onboarding->save()) {
        return redirect()->route('onboarding')->with('success', 'Data has been successfully updated.');
    } else {
        return redirect()->back()->with('error', 'Sorry, data update failed.');
    }
}

}
