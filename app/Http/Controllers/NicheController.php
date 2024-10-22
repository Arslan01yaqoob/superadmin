<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Niche;
use Illuminate\Http\Request;

class NicheController extends Controller
{

    public function view()
    {

      return     $niches = Niche::with('category')->withCount(['servicesname' => function ($query) {
            $query->where('status', 1)->where('approval_status','approved');
        }])->get();
      
    }

    public function addpage()
    {

        return   $categories = Category::where('status', 1)->get();

     
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

        return response()->json(['success' => true]);
    }

    public function updatepage(Request $request)
    {

        $id= $request->id;

        $niche = Niche::with('category')->findorfail($id);
        $categories = Category::where('status', 1)->get();



        return response()->json([
            'Niche'=>$niche,
            'Categories' => $categories,         
        ]);
    
    }
    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'niche_name' => 'required|string|max:50',
            'niche_category_id' => 'required|integer|exists:categories,id',
            'niche_description' => 'nullable|string|max:255',
        ]);
    
$id = $request->id;

        $niche = Niche::findOrFail($id);
    
        $niche->niche_name = $validatedData['niche_name'];
        $niche->category_id = $validatedData['niche_category_id'];
        $niche->niche_description = $validatedData['niche_description'];
    
        $niche->save();
    
        return response()->json(['success' => true]);
    }
    

}
