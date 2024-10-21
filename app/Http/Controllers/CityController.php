<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function view()
    {
        return   $cities = Cities::with('country', 'state')->get();
       
    }
    


    public function addpage()
    {

        return  $countries = Countries::where('status', 1)->get();
           
    }


    public function add(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_name' => 'required|string|max:50',
        ]);
    
        
        $city = new Cities();
        $city->city_name = $request->city_name;
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id; 
    
        $city->save();
        
        return response()->json(['success' => true]);


    }
    
    public function status(Request $request)
    {

        $cities = Cities::find($request->id);
        $cities->status = !$cities->status;
        $cities->save();
        return response()->json(['success' => true]);
    }

    public function updatepage(request $request)
    {
$id = $request->id;

        $city = Cities::with('country', 'state')->find($id);
    
        $countries = Countries::where('status',1)->get();
        $states = State::where('country_id', $city->country_id)->where('status',1)->get(); 

        return response()->json([
            'city'=>$city,
            'states' => $states,
            'countries' => $countries,
        ]);

    }
    



    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
        ]);
    
$id = $request->id;

        $city = Cities::findOrFail($id);
    
        $city->update([
            'city_name' => $validatedData['name'],
            'state_id' => $validatedData['state_id'],
            'country_id' => $validatedData['country_id'],
        ]);
    
        // Redirect or return a response
        return response()->json(['success' => true]);
    }
    

    public function destroy(Request $request)
    {


        $city = Cities::find($request->cityid);
        $countryId = $city->country_id;

        if ($city) {
            $city->delete();

            return redirect()->route('cities', ['id' => $countryId])
                ->with('success', 'City deleted successfully!');
        } else {
            return back()->with('error', 'City not found.');
        }
    }
    public function details($id)
    {

        return   $cities = Cities::where('state_id', $id)->where('status', 1)->get();
    }
}
