<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Countries;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProfessionalController extends Controller
{

    public function view()
    {

            $professional = Professional::with('country')->with('state')->with('city')->get();

        return view('Professional.professionals', compact('professional'));
    }

    public function addpage()
    {
        $country = Countries::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('Professional.add', compact('country', 'categories'));
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

    public function checkPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_num' => 'required|string|max:15|regex:/^[0-9\-\+\s]*$/',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $phone_num = $request->phone_num;
        $exists = Professional::where('phone_number', $phone_num)->exists();
        return response()->json(['available' => !$exists]);
    }



    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:professionals,username',
            'email' => 'required|email|max:255|unique:professionals,email',
            'phone_num' => 'required|string|max:20|unique:professionals,phone_number',
            'password' => 'required|string|min:6',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'area' => 'required|string|max:255',
            'working_range' => 'required|integer|min:1|max:15',
            'category_id' => 'required|integer|exists:categories,id',
            'bussnies_type' => 'required|string',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'working_days' => 'required|array|min:1',
            'description' => 'nullable|string',
            'backgrounpic' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Background image is nullable
            'profilepicinput' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Profile pic is nullable
        ]);

        $professional = new Professional;

        if ($request->hasFile('profilepicinput')) {
            $uploadedprofileImage = $request->file('profilepicinput');
            $imageprofileSize = $uploadedprofileImage->getSize(); // File size in bytes
            $maxprofileSize = 500 * 1024; // 500KB in bytes

            $uploadedprofileImage = $request->file('profilepicinput');
            $manager = new ImageManager(new Driver());

            $image = $request->file('profilepicinput');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/professional/profilepic/';
            $img = $manager->read($uploadedprofileImage);
            if ($imageprofileSize > $maxprofileSize) {
                $img->resize(180, 180);
            }


            $img->toJpeg(80)->save(base_path('public/images/professional/profilepic/' . $filename));

            $professional->logo_url = $imagePath . $filename;
        } else {
            $professional->logo_url = 'assets/imgs/placeholders/avatar_p.jpg';
        }
        if ($request->hasFile('backgrounpic')) {

            $uploadedImage = $request->file('backgrounpic');
            $imageSize = $uploadedImage->getSize(); // File size in bytes
            $maxSize = 500 * 1024; // 500KB in bytes

            $uploadedimage = $request->file('backgrounpic');
            $manager = new ImageManager(new Driver());

            $image = $request->file('backgrounpic');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/professional/coverpic/';
            $img = $manager->read($uploadedimage);
            if ($imageSize > $maxSize) {
                $img->resize(640, 360);
            }


            $img->toJpeg(80)->save(base_path('public/images/professional/coverpic/' . $filename));

            $professional->cover_image_url = $imagePath . $filename;
        } else {
            $professional->cover_image_url = 'assets/imgs/placeholders/cover_p.jpg';
        }

        $professional->name = $request->name;
        $professional->username = $request->username;
        $professional->business_type = $request->bussnies_type;
        $professional->business_category = $request->category_id;
        $professional->phone_number = $request->phone_num;
        $professional->email = $request->email;
        $professional->password = $request->password;
        $professional->country_id = $request->country_id;
        $professional->state_id = $request->state_id;
        $professional->city_id = $request->city_id;
        $professional->address = $request->address;
        $professional->latitude = $request->latitude;
        $professional->logitude = $request->longitude;
        $professional->area_name = $request->area;
        $professional->working_range = $request->working_range;
        $professional->description = $request->description;
        $professional->working_days = implode(',', $request->working_days);

        $professional->working_time_start = $request->working_hours_start;
        $professional->working_time_end = $request->working_hours_end;


        if ($professional->save()) {
            return redirect(route('Professional'))->with('success', 'Professional added successfully!');
        } else {
            return back()->with('error', 'There was an error adding.');
        }
    }
}
