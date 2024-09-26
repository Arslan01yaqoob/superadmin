<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Countries;
use Illuminate\Http\Request;

class MerchantController extends Controller
{

    public function view()
    {
        return view('Merchants.merchnats');
    }

    public function addpage()
    {
        $country = Countries::where('status', 1)->get();
        $categories= Category::where('status',1)->get();

        return view('Merchants.add', compact('country','categories'));



    }
}
