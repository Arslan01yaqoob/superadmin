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

        $servicesnames = Services_names::with('niche')
            ->with('category')
            ->get();

        return view('ServicesNames.services', compact('servicesnames'));
    }
    public function addpage()
    {
        $categories = Category::where('status', '1')->get();
        return view('ServicesNames.add', compact('categories'));
    }

    public function editpage()
    {
        return view('ServicesNames.edit');
    }
    public function details($id)
    {
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


        if ($service->save()) {
            return redirect()->route('service.names')->with('success', 'service name added successfully!');
        } else {
            return back()->with('error', 'There was an error adding the Service name.');
        }
    }

    public function status(Request $request)
    {

        $servicename = Services_names::find($request->id);
        $servicename->status = !$servicename->status;
        $servicename->save();
        return response()->json(['success' => true]);
    }

    public function updatepage($id)
    {

        $servicename = Services_names::with('niche')
            ->with('category')
            ->find($id);

        $categories = Category::where('status', '1')->get();
        $niches = Niche::where('status', '1')
            ->where('category_id', $servicename->category_id)
            ->get();


        return view('ServicesNames.edit', compact('servicename', 'categories', 'niches'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'service_name' => 'required|string|max:50',
            'category_id' => 'required|integer|exists:categories,id',
            'niche_id' => 'required|integer|exists:niches,id',
        ]);

        $service = Services_names::findOrFail($id);

        $service->service_name = $validatedData['service_name'];
        $service->category_id = $validatedData['category_id'];
        $service->niche_id = $validatedData['niche_id'];

        if ($service->save()) {
            return redirect()->route('service.names')->with('success', 'Service name updated successfully!');
        } else {
            return back()->with('error', 'There was an error updating the Service name.');
        }
    }
}
