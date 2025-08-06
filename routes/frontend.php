<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendCategoryController;



Route::get('/', function () {
    return view('auth.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');


