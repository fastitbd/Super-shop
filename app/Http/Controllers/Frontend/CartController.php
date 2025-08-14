<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = cart::instance('cart')->content();
        return view('frontend.pages.cart',['cartItems'=>$cartItems]);
    }
}
