<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProductDetailsController;
use App\Http\Controllers\Frontend\FrontendCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\OrderController;



Route::get('/', function () {
    return view('auth.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/product/details/{slug}', [ProductDetailsController::class, 'details'])->name('product.details');

Route::get('category/{url}', [FrontendCategoryController::class, 'category'])->name('category.page');

Route::get('subcategory/{url}', [FrontendCategoryController::class, 'subcategory'])->name('subcategory.page');
Route::get('subcategory/productlist', [FrontendCategoryController::class, 'showCategoriesWithProducts'])->name('subcategory.productlist');


Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');

Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.store');
Route::post('/wishlist/remove', [WishlistController::class, 'removeProduct'])->name('wishlist.remove');
// Add all wishlist items to cart
Route::post('/wishlist/add-all-to-cart', [WishlistController::class, 'addAllToCart'])->name('wishlist.addAllToCart');

Route::resource('order', OrderController::class)->except(['show', 'edit', 'create']);



