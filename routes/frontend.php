<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProductDetailsController;



Route::get('/', function () {
    return view('auth.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/product/details/{slug}', [ProductDetailsController::class, 'details'])->name('product.details');



