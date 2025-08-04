<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;



Route::get('/', function () {
    return view('auth.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');
