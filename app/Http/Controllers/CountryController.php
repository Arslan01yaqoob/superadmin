<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function view()
    {
        
        
        return   $Countries = Countries::withCount([
            'states as active_states_count' => function ($query) {
                $query->where('status', 1); 
            },
            'cities as active_cities_count' => function ($query) {
                $query->where('status', 1);
            }
        ])->get();
        

    }

    public function addpage()
    {
        return view('Countries.add');
    }

    public function add(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:50',
        ]);
        $country = new Countries();
        $country->country_name = $request->countryName;

        if ($country->save()) {
            return redirect('countries')->with('success', 'Country added successfully!');
        } else {
            return back()->with('error', 'There was an error adding the country.');
        }
    }



    public function status(Request $request)
    {
        $country = Countries::find($request->id);
        $country->status = !$country->status;
        $country->save();
        return response()->json(['success' => true]);
    }

    public function updatepage(request $request)
    {
        return  $country = Countries::find($request->id);

    
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'country_name' => 'required|string|max:50',
        ]);

        $country = Countries::findOrFail($id);
        $country->country_name = $request->country_name;

        if ($country->save()) {
            return redirect('countries')->with('success', 'Country updated successfully!');
        } else {
            return back()->with('error', 'There was an error updating the country.');
        }
    }

}
