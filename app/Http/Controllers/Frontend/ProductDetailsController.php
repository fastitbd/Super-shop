<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

use Illuminate\Http\Request;




class ProductDetailsController extends Controller
{
    public function details($slug){

        $product=Product::with(['category.subcategories','unit','brand'])->where('slug',$slug)->firstOrFail();

        $featureproduct = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(10)->get();

        return view('frontend.pages.details',compact('product','featureproduct'));
      }



}

