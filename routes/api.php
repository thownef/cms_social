<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
});

Route::apiResource('profiles', \App\Http\Controllers\Api\ProfileController::class)->only(['show']);
Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class)->only(['show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::controller(\App\Http\Controllers\Api\AuthController::class)->group(function () {
            Route::get('me', 'me')->name('.me');
            Route::post('logout', 'logout')->name('.logout');
        });
    });
    Route::put('profiles', [\App\Http\Controllers\Api\ProfileController::class, 'update'])->name('profiles.update');
    Route::apiResource('work-history', \App\Http\Controllers\Api\WorkHistoryController::class);
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class)->only(['index', 'store', 'update', 'destroy']);
});
