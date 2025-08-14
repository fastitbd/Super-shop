<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProductDetailsController;
use App\Http\Controllers\Frontend\FrontendCategoryController;
use App\Http\Controllers\Frontend\CartController;



Route::get('/', function () {
    return view('auth.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/product/details/{slug}', [ProductDetailsController::class, 'details'])->name('product.details');

Route::get('category/{url}', [FrontendCategoryController::class, 'category'])->name('category.page');

Route::get('subcategory/{url}', [FrontendCategoryController::class, 'subcategory'])->name('subcategory.page');
Route::get('subcategory/productlist', [FrontendCategoryController::class, 'showCategoriesWithProducts'])->name('subcategory.productlist');


Route::get('/cart',[CartController::class, 'index'])->name('cart.index');



