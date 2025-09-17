<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = cart::instance('cart')->content();
        return view('frontend.pages.cart', ['cartItems' => $cartItems]);
    }

public function addToCart(Request $request)
{
    $product = Product::find($request->id);
    $price = $product->selling_price ? $product->selling_price : $product->after_discount_price;

    \Cart::instance('cart')->add(
        $product->id,
        $product->name,
        $request->quantity,
        $price
    )->associate('App\Models\Product');

        $wishlist = session()->get('wishlist', []);
    if (($key = array_search($product->id, $wishlist)) !== false) {
        unset($wishlist[$key]);
        session()->put('wishlist', $wishlist);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Item has been added successfully!',
        'cart_count' => \Cart::instance('cart')->count()
    ]);
}


    public function updateCart(Request $request)
    {
        Cart::instance('cart')->update($request->rowId, $request->quantity);
        return redirect()->route('cart.index');
    }

    public function removeItem(Request $request)
    {
        $rowId = $request->rowId;
        Cart::instance('cart')->remove($rowId);
        return redirect()->route('cart.index');
    }

    public function clearCart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->route('cart.index');
    }
}
