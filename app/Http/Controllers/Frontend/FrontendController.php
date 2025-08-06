<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShopBanner;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {   $shopbanners = ShopBanner::all();
        return view('frontend.pages.home', compact('shopbanners'));
    }
 
 

}
