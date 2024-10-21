<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Api\Auth\AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
});

Route::middleware('auth:sanctum')->group( function () {
    //
});
