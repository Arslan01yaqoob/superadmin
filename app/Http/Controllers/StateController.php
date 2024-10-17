<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function view()
    {
        return  $states = State::with('country')
            ->withCount([
                'cities as active_cities_count' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->get();
    
    }

    public function addpage()
    {
        return  $countries = Countries::where('status', 1)->get();
         view('States.add', compact('countries'));
    }

    public function add(request $request)
    {
        $validatedData = $request->validate([
            'state_name' => 'required|string|max:50',
            'country_id' => 'required|integer'
        ]);
    
        // Proceed to save the state if validation passes
        $state = new State();
        $state->state_name = $validatedData['state_name'];
        $state->country_id = $validatedData['country_id'];
        $state->save();
    
        return response()->json(['success' => true]);
    }
    


    public function status(Request $request)
    {
        $state = State::find($request->id);
        $state->status = !$state->status;
        $state->save();
        return response()->json(['success' => true]);
    }

    public function updatepage(request $request)
    {
$id= $request->id;

        $state = State::with('country')->find($id);
        $countries = Countries::where('status', 1)->get();
   
        return response()->json([
            'state' => $state,
            'countries' => $countries,
        ]);
    

    }
    public function update(request $request)
    {

$id = $request->state_id;

        $validated = $request->validate([
            'state_name' => 'required|string|max:50|unique:states,state_name,' . $id,
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $state = State::findOrFail($id);

        $state->state_name = $validated['state_name'];
        $state->country_id = $validated['country_id'];

        $state->save();

        return response()->json(['success' => true]);
    }

    public function details($id)
    {

        return $state = State::where('country_id', $id)->where('status', 1)->get();
    }
}
