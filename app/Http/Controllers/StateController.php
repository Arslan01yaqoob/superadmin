<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function view()
    {
        $states = State::with('country')
            ->withCount([
                'cities as active_cities_count' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->get();
    
        return view('States.states', compact('states'));
    }

    public function addpage()
    {
        $countries = Countries::where('status', 1)->get();
        return view('States.add', compact('countries'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'state_name' => 'required|string|max:50|unique:states,state_name',

            'country_id' => 'required|exists:countries,id', // Ensure country_id exists in the countries table
        ]);

        $state = new State();
        $state->state_name = $validated['state_name'];
        $state->country_id = $validated['country_id'];
        $state->save();

        return redirect('states')->with('success', 'State added successfully!');
    }
    public function status(Request $request)
    {
        $state = State::find($request->id);
        $state->status = !$state->status;
        $state->save();
        return response()->json(['success' => true]);
    }

    public function updatepage($id)
    {
        $state = State::with('country')->find($id);
        $countries = Countries::where('status', 1)->get();
        return view('States.edit', compact('state', 'countries'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'state_name' => 'required|string|max:50|unique:states,state_name,' . $id,
            'country_id' => 'required|exists:countries,id',
        ]);

        $state = State::findOrFail($id);

        $state->state_name = $validated['state_name'];
        $state->country_id = $validated['country_id'];

        $state->save();

        return redirect('states')->with('success', 'State updated successfully!');
    }

    public function details($id)
    {

        return $state = State::where('country_id', $id)->where('status', 1)->get();
    }
}
