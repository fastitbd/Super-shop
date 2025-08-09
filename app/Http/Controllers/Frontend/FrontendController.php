<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShopBanner;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $shopbanners = ShopBanner::all();

        $firstCategories = Category::with([
            'products' => function ($query) {
                $query->where('status', 1)->orderBy('id', 'asc');
            }
        ])->where('status', 1)->orderBy('id', 'ASC')->take(5)->get();

        $remainingCategories = Category::where('status', 1)
            ->orderBy('id', 'asc')
            ->skip(5)
            ->take(PHP_INT_MAX)  // or any large number 
            ->with([
                'products' => function ($query) {
                    $query->where('status', 1)->orderBy('id', 'asc');
                }
            ])->get();

        return view('frontend.pages.home', compact('shopbanners', 'firstCategories', 'remainingCategories'));
    }



}
