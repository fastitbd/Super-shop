<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class FrontendCategoryController extends Controller
{

    public function category($url)
    {
        $cate = Category::where('status', 1)->where('url', $url)->firstOrFail();

        $all = Product::with('subcategory')->where('category_id', $cate->id)->orderBy('id', 'asc')->latest()->get();

        $subcategories = $cate->subcategories;

        $subcategoryId = null;

        return view('frontend.pages.category.category', compact('cate', 'subcategories', 'all', 'subcategoryId'));
    }

    public function subcategory($url)
    {


        $subcate = SubCategory::with('category')->where('status', 1)->where('url', $url)->firstOrFail();

        $all = Product::where('subcategory_id', $subcate->id)
            ->orderBy('id', 'desc')
            ->get();


        $cate = $subcate->category;

        return view('frontend.pages.category.subcategory', compact('subcate', 'all', 'cate'));
    }



}
