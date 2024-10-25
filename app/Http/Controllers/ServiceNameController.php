<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Niche;
use App\Models\Services_names;
use Illuminate\Http\Request;

class ServiceNameController extends Controller
{

    public function view()
    {

        return  $servicesnames = Services_names::with('niche')
            ->with('category')
            ->get();
    }
    public function addpage()
    {
        return  $categories = Category::where('status', '1')->get();
    }

   
    public function details(request $request)
    {
        $id = $request->id;
        return $nicehs = Niche::where('status', '1')
            ->where('category_id', $id)
            ->get();
    }

    public function add(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'service_name' => 'required|string|max:50',
            'category_id' => 'required|integer|exists:categories,id',
            'niche_id' => 'required|integer|exists:niches,id',
        ]);
        $service = new Services_names;
        $service->service_name = $validatedData['service_name'];
        $service->category_id = $validatedData['category_id'];
        $service->niche_id = $validatedData['niche_id'];

        $service->save();


        return response()->json(['success' => true]);
    }

    public function status(Request $request)
    {

        $servicename = Services_names::find($request->id);
        $servicename->status = !$servicename->status;
        $servicename->save();
        return response()->json(['success' => true]);
    }

    public function updatepage(request $request)
    {

        // $id = $request->id;

        $servicename = Services_names::with('niche')
            ->with('category')
            ->find(2);

        $categories = Category::where('status', '1')->get();
        $niches = Niche::where('status', '1')
            ->where('category_id', $servicename->category_id)
            ->get();


        return response()->json([
            'servicename' => $servicename,
            'categories' => $categories,
            'niches' => $niches,
        ]);
    }
    public function update(Request $request)
    {

        $id = $request->id;

        $validatedData = $request->validate([
            'service_name' => 'required|string|max:50',
            'category_id' => 'required|integer|exists:categories,id',
            'niche_id' => 'required|integer|exists:niches,id',
        ]);

        $service = Services_names::findOrFail($id);

        $service->service_name = $validatedData['service_name'];
        $service->category_id = $validatedData['category_id'];
        $service->niche_id = $validatedData['niche_id'];

        $service->save();


        return response()->json(['success' => true]);
        
        
    }
}
