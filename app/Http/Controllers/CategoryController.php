<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function view()
    {

        $categories = Category::get();
        return view('Categories.categories', compact('categories'));
    }

    public function addpage()
    {
        return view('Categories.add');
    }

    public function add(Request $request)
    {


        $validated = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_subtitle' => 'nullable|string|max:100',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // 1MB in kilobytes
        ]);

        $category = new Category;

        $category->category_name = $request->category_name;
        $category->short_description = $request->category_subtitle;
        $uploadedImage = $request->file('category_image');
        $imageSize = $uploadedImage->getSize(); // File size in bytes
        $maxSize = 500 * 1024; // 500KB in bytes

        if ($request->hasFile('category_image')) {

            $uploadedimage = $request->file('category_image');
            $manager = new ImageManager(new Driver());

            $image = $request->file('category_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/categories/';
            $img = $manager->read($uploadedimage);
            if ($imageSize > $maxSize) {
                $img->resize(500, 500);
            }


            $img->toJpeg(80)->save(base_path('public/images/categories/' . $filename));

            $category->category_image = $imagePath . $filename;
        }

        $category->save();


        if ($category->save()) {
            return redirect('categories')->with('success', 'Category added successfully!');
        } else {
            return back()->with('error', 'There was an error adding the category.');
        }
    }
    public function status(Request $request)
    {

        $category = Category::find($request->id);
        $category->status = !$category->status;
        $category->save();
        return response()->json(['success' => true]);
    }
    public function updatepage($id)
    {

        $category = Category::find($id);

        return view('Categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $validated = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_subtitle' => 'nullable|string|max:100',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // 1MB in kilobytes
        ]);

        $category->category_name = $request->category_name;
        $category->short_description = $request->category_subtitle;

        if ($request->hasFile('category_image')) {
            $uploadedImage = $request->file('category_image');
            $imageSize = $uploadedImage->getSize(); // File size in bytes
            $maxSize = 500 * 1024; // 500KB in bytes

            $manager = new ImageManager(new Driver());
            $filename = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $imagePath = 'images/categories/';
            $img = $manager->read($uploadedImage);

            if ($imageSize > $maxSize) {
                $img->resize(500, 500);
            }

            $img->toJpeg(80)->save(base_path('public/' . $imagePath . $filename));

            // Remove old image if exists
            if ($category->category_image && file_exists(public_path($category->category_image))) {
                // Delete the file
                unlink(public_path($category->category_image));
            }

            $category->category_image = $imagePath . $filename;
        }

        $category->save();

        if ($category->save()) {
            return redirect('categories')->with('success', 'Category updated successfully!');
        } else {
            return back()->with('error', 'There was an error updating the category.');
        }
    }




    

    
}
