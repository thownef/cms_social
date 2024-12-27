<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register'])->name('register');
});

Route::apiResource('profile', \App\Http\Controllers\Api\Auth\ProfileController::class)->only(['show']);

Route::middleware('auth:sanctum')->group( function () {
    Route::prefix('auth')->group(function () {
        Route::controller(App\Http\Controllers\Api\Auth\AuthController::class)->group(function () {
            Route::get('me', 'me')->name('.me');
            Route::post('logout', 'logout')->name('.logout');
        });
    });
    Route::apiResource('profile', \App\Http\Controllers\Api\Auth\ProfileController::class)->only(['update']);
    Route::apiResource('work-history', \App\Http\Controllers\Api\Auth\WorkHistoryController::class)->only(['store', 'update', 'destroy']);
});
