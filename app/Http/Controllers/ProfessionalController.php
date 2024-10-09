<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Professional;
use App\Models\State;
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
            'working_hours_start' => 'required',
            'working_hours_end' => 'required|after:working_hours_start',
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
    public function professionaldetails($id)
    {

        $professional = Professional::with('category')
            ->with('country')
            ->with('state')
            ->with('city')
            ->find($id);

        return  view('Professional.details', compact('professional'));
    }
    public function accountstatus($status, $user)
    {
        $user = Professional::findOrFail($user);

        switch ($status) {
            case 1:
                $user->account_status = "Temporarily Blocked";
                break;
            case 2:
                $user->account_status = "Account Suspended";
                break;
            case 3:
                $user->account_status = "Account Blocked";
                break;
            case 4:
                $user->account_status = "Active Account";
                break;
            default:
                return back()->with('error', 'Invalid status.');
        }

        if ($user->save()) {
            return redirect()->route('Professional')->with('success', 'Account status updated successfully!');
        } else {
            return back()->with('error', 'There was an error.');
        }
    }
    public function updatepage($id)
    {

        $professional = Professional::with('category')
            ->with('country')
            ->with('state')
            ->with('city')
            ->with('category')
            ->find($id);
        $country = Countries::where('status', 1)->get();
        $sates = State::where('status', 1)->where('country_id', $professional->country->id)->get();
        $cities = Cities::where('status', 1)->where('state_id', $professional->state->id)->get();


        $categories = Category::where('status', 1)->get();

        return view('Professional.edit', compact('professional', 'country', 'categories', 'sates', 'cities'));
    }
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:professionals,username,' . $id,
            'email' => 'required|email|max:255|unique:professionals,email,' . $id,
            'phone_num' => 'required|string|max:20|unique:professionals,phone_number,' . $id,

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
            'working_hours_start' => 'required',
            'working_hours_end' => 'required|after:working_hours_start',
            'working_days' => 'required|array|min:1',
            'description' => 'nullable|string',
            'backgrounpic' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Background image is nullable
            'profilepicinput' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Profile pic is nullable
        ]);

        // Find the professional by ID
        $professional = Professional::findOrFail($id);

        // Profile picture update
        if ($request->hasFile('profilepicinput')) {
            // Check if the professional already has a profile picture
            if ($professional->logo_url && file_exists(public_path($professional->logo_url))) {
                // Unlink (delete) the old image
                unlink(public_path($professional->logo_url));
            }

            // Process the new profile image
            $uploadedprofileImage = $request->file('profilepicinput');
            $imageprofileSize = $uploadedprofileImage->getSize();
            $maxprofileSize = 500 * 1024;

            $manager = new ImageManager(new Driver());
            $filename = time() . '.' . $uploadedprofileImage->getClientOriginalExtension();
            $imagePath = 'images/professional/profilepic/';
            $img = $manager->read($uploadedprofileImage);

            if ($imageprofileSize > $maxprofileSize) {
                $img->resize(180, 180);
            }

            $img->toJpeg(80)->save(base_path('public/' . $imagePath . $filename));

            // Save the new image URL
            $professional->logo_url = $imagePath . $filename;
        }

        // Cover image update
        if ($request->hasFile('backgrounpic')) {
            // Check if the professional already has a cover image
            if ($professional->cover_image_url && file_exists(public_path($professional->cover_image_url))) {
                // Unlink (delete) the old cover image
                unlink(public_path($professional->cover_image_url));
            }

            // Process the new cover image
            $uploadedImage = $request->file('backgrounpic');
            $imageSize = $uploadedImage->getSize();
            $maxSize = 500 * 1024;

            $manager = new ImageManager(new Driver());
            $filename = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $imagePath = 'images/professional/coverpic/';
            $img = $manager->read($uploadedImage);

            if ($imageSize > $maxSize) {
                $img->resize(640, 360);
            }

            $img->toJpeg(80)->save(base_path('public/' . $imagePath . $filename));

            // Save the new cover image URL
            $professional->cover_image_url = $imagePath . $filename;
        }

        // Update other fields
        $professional->name = $request->name;
        $professional->username = $request->username;
        $professional->business_type = $request->bussnies_type;
        $professional->business_category = $request->category_id;
        $professional->phone_number = $request->phone_num;
        $professional->email = $request->email;
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

        // Save the updated professional
        if ($professional->save()) {
            return redirect(route('Professional'))->with('success', 'Professional updated successfully!');
        } else {
            return back()->with('error', 'There was an error updating the professional.');
        }
    }



    
}
