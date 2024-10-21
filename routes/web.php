<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (){
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'index']);
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name("login");
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
