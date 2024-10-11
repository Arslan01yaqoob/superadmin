<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Niche;
use Illuminate\Http\Request;

class NicheController extends Controller
{

    public function view()
    {

        $niches = Niche::with('category')->get();
        return view('Niches.niches', compact('niches'));
    }

    public function addpage()
    {

        $categories = Category::where('status', 1)->get();

        return view('Niches.add', compact('categories'));
    }

    public function status(Request $request)
    {

        $Niche = Niche::find($request->id);
        $Niche->status = !$Niche->status;
        $Niche->save();
        return response()->json(['success' => true]);
    }


    public function add(Request $request)
    {

        $validatedData = $request->validate([
            'niche_name' => 'required|string|max:50',
            'niche_category_id' => 'required|integer|exists:categories,id',
            'niche_description' => 'nullable|string|max:255',
        ]);

        $niche = new Niche;

        $niche->niche_name = $request->niche_name;
        $niche->category_id = $request->niche_category_id;
        $niche->niche_description = $request->niche_description;

        $niche->save();

        return redirect()->route('niches')->with('success', 'Niche added successfully');
    }

    public function updatepage($id)
    {
        $niche = Niche::with('category')->findorfail($id);
        $categories = Category::where('status', 1)->get();
        return view('Niches.edit', compact('niche','categories'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'niche_name' => 'required|string|max:50',
            'niche_category_id' => 'required|integer|exists:categories,id',
            'niche_description' => 'nullable|string|max:255',
        ]);
    
        $niche = Niche::findOrFail($id);
    
        $niche->niche_name = $validatedData['niche_name'];
        $niche->category_id = $validatedData['niche_category_id'];
        $niche->niche_description = $validatedData['niche_description'];
    
        $niche->save();
    
        return redirect()->route('niches')->with('success', 'Niche updated successfully');
    }
    

}
