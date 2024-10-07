<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class userController extends Controller
{

    public function view()
    {
        $user = User::with('country')->with('state')->with('city')->get();
        return  view('Users.users', compact('user'));
    }
    public function addpage()
    {
        $country = Countries::where('status', 1)->get();

        return view('Users.add', compact('country'));
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
        $exists = User::where('username', $username)->exists();
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
        $exists = User::where('email', $email)->exists();
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
        $exists = User::where('phone_num', $phone_num)->exists();
        return response()->json(['available' => !$exists]);
    }
    public function add(Request $request)
    {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'gender' => 'required|in:male,female,other',
                'email' => 'nullable|email|max:255|unique:users,email',
                'phone_num' => 'nullable|string|max:20|unique:users,phone_num',
                'confirm_password' => 'required|min:6',
                'country_id' => 'required|integer|exists:countries,id',
                'state_id' => 'required|integer|exists:states,id',
                'city_id' => 'required|integer|exists:cities,id',
                'date_of_birth' => 'required|date|before:18 years ago',
                'address' => 'required|string|max:500',
                'description' => 'nullable|string|max:500',
                'backgrounpic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
                'profilepicinput' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
                'password' =>'required|string|min:6'
            ]);

        $user = new User;

        if ($request->hasFile('profilepicinput')) {
            $uploadedprofileImage = $request->file('profilepicinput');
            $imageprofileSize = $uploadedprofileImage->getSize(); // File size in bytes
            $maxprofileSize = 500 * 1024; // 500KB in bytes

            $uploadedprofileImage = $request->file('profilepicinput');
            $manager = new ImageManager(new Driver());

            $image = $request->file('profilepicinput');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/users/profilepic/';
            $img = $manager->read($uploadedprofileImage);
            if ($imageprofileSize > $maxprofileSize) {
                $img->resize(180, 180);
            }


            $img->toJpeg(80)->save(base_path('public/images/users/profilepic/' . $filename));

            $user->image_url = $imagePath . $filename;
        } else {
            $user->image_url = 'assets/imgs/placeholders/avatar.jpg';
        }

        if ($request->hasFile('backgrounpic')) {

            $uploadedImage = $request->file('backgrounpic');
            $imageSize = $uploadedImage->getSize(); // File size in bytes
            $maxSize = 500 * 1024; // 500KB in bytes

            $uploadedimage = $request->file('backgrounpic');
            $manager = new ImageManager(new Driver());

            $image = $request->file('backgrounpic');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/users/coverpic/';
            $img = $manager->read($uploadedimage);
            if ($imageSize > $maxSize) {
                $img->resize(640, 360);
            }


            $img->toJpeg(80)->save(base_path('public/images/users/coverpic/' . $filename));

            $user->cover_image_url = $imagePath . $filename;
        } else {
            $user->cover_image_url = 'assets/imgs/placeholders/cover.jpg';
        }

        $user->name    = $request->name;
        $user->username    = $request->username;
        $user->description    = $request->description;
        $user->phone_num    = $request->phone_num;
        $user->email    = $request->email;
        $user->address    = $request->address;
        $user->gendar    = $request->gender;
        $user->country_id    = $request->country_id;
        $user->state_id    = $request->state_id;
        $user->city_id    = $request->city_id;
        $user->date_of_birth    = $request->date_of_birth;
        $user->password    = $request->password;

        $user->save();


        if ($user->save()) {
            return redirect('users')->with('success', 'User added successfully!');
        } else {
            return back()->with('error', 'There was an error adding the category.');
        }
    }
    public function status(Request $request)
    {

        $user = User::find($request->id);
        $user->status = !$user->status;
        $user->save();
        return response()->json(['success' => true]);
    }
    public function usersdetails($id)
    {
        $user = User::with('country')->with('city')->findorfail($id);
        return view('Users.details', compact('user'));
    }
    public function editpage($id)
    {
        $user = User::with('country')->with('city')->with('state')->findorfail($id);
        $countries = Countries::where('status', 1)->get();
        $sates = State::where('status', 1)->where('country_id', $user->country->id)->get();
        $cities = Cities::where('status', 1)->where('state_id', $user->state->id)->get();


        return view('Users.edit', compact('user', 'countries', 'cities', 'sates'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'gender' => 'required|in:male,female,other',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone_num' => 'nullable|string|max:20|unique:users,phone_num,' . $user->id,
            'confirm_password' => 'nullable|min:6',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'date_of_birth' => 'required|date|before:18 years ago',
            'address' => 'required|string|max:500',
            'description' => 'nullable|string|max:500',
            'backgrounpic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'profilepicinput' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // Profile picture update
        if ($request->hasFile('profilepicinput')) {
            $uploadedprofileImage = $request->file('profilepicinput');
            $imageprofileSize = $uploadedprofileImage->getSize();
            $maxprofileSize = 500 * 1024; // 500KB in bytes

            $manager = new ImageManager(new Driver());
            $filename = time() . '.' . $uploadedprofileImage->getClientOriginalExtension();
            $imagePath = 'images/users/profilepic/';
            $img = $manager->read($uploadedprofileImage);

            if ($imageprofileSize > $maxprofileSize) {
                $img->resize(180, 180);
            }

            $img->toJpeg(80)->save(base_path('public/' . $imagePath . $filename));

            // Remove old image if exists
            if ($user->image_url != 'assets/imgs/placeholders/avatar.jpg') {
                File::delete(base_path('public/' . $user->image_url));
            }

            $user->image_url = $imagePath . $filename;
        }

        // Background picture update
        if ($request->hasFile('backgrounpic')) {
            $uploadedImage = $request->file('backgrounpic');
            $imageSize = $uploadedImage->getSize();
            $maxSize = 500 * 1024; // 500KB in bytes

            $manager = new ImageManager(new Driver());
            $filename = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $imagePath = 'images/users/coverpic/';
            $img = $manager->read($uploadedImage);

            if ($imageSize > $maxSize) {
                $img->resize(640, 360);
            }

            $img->toJpeg(80)->save(base_path('public/' . $imagePath . $filename));

            // Remove old image if exists
            if ($user->cover_image_url != 'assets/imgs/placeholders/cover.jpg') {
                File::delete(base_path('public/' . $user->cover_image_url));
            }

            $user->cover_image_url = $imagePath . $filename;
        }

        // Update user fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->description = $request->description;
        $user->phone_num = $request->phone_num;
        $user->email = $request->email;

        $user->address = $request->address;
        $user->gendar = $request->gender;
        $user->country_id = $request->country_id;
        $user->state_id    = $request->state_id;

        $user->city_id = $request->city_id;
        $user->date_of_birth = $request->date_of_birth;

        // Password update (if provided)
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            return redirect('users')->with('success', 'User updated successfully!');
        } else {
            return back()->with('error', 'There was an error updating the user.');
        }
    }
    public function accountstatus($status, $user)
    {
        $user = User::findOrFail($user);

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
            return redirect('users')->with('success', 'Account status updated successfully!');
        } else {
            return back()->with('error', 'There was an error.');
        }
    }
    
}
