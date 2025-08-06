<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;




class ProductDetailsController extends Controller
{
    public function details($slug){
        $product=Product::where('slug',$slug)->firstOrFail();
        return view('frontend.pages.details',compact('product'));
      }
}

