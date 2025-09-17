<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {



        $data['cartItems'] = \Cart::instance('cart')->content();

        $cartTotal = (float) str_replace(',', '', \Cart::instance('cart')->subtotal(2, '.', ','));

    
        return view('frontend.pages.checkout', $data, compact('cartTotal'));
    }
}
