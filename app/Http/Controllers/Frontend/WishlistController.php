<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{ // Show wishlist
    public function index()
    {
        $wishlist = session()->get('wishlist', []);

        // Load products
        $wishlistItems = Product::whereIn('id', $wishlist)->get();

        return view('frontend.pages.wishlist', compact('wishlistItems'));
    }

    // Add product to wishlist
    public function addToWishlist(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);

            $wishlist = session()->get('wishlist', []);

            if (!in_array($product->id, $wishlist)) {
                $wishlist[] = $product->id;
                session()->put('wishlist', $wishlist);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Item added to wishlist!',
                'wishlist_count' => count($wishlist)
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Wishlist error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error'
            ], 500);
        }
    }

    // Remove single product from wishlist
    public function removeProduct(Request $request)
    {
        try {
            $wishlist = session()->get('wishlist', []);

            if (($key = array_search($request->id, $wishlist)) !== false) {
                unset($wishlist[$key]);
                session()->put('wishlist', $wishlist);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Item removed from your wishlist',
                'wishlist_count' => count($wishlist)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    // Add all wishlist items to cart
    public function addAllToCart()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlist)->get();

        foreach ($products as $product) {
            \Cart::instance('cart')->add([
                'id'    => $product->id,
                'name'  => $product->name,
                'qty'   => 1,
                'price' => $product->selling_price,
            ])->associate('App\Models\Product');
        }

        // Clear wishlist after adding to cart
        session()->forget('wishlist');

        return response()->json([
            'status'     => 200,
            'message'    => 'All wishlist items added to cart!',
            'cart_count' => \Cart::instance('cart')->count()
        ]);
    }


}
