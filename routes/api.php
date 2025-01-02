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
    // Profile
    Route::put('profiles', [\App\Http\Controllers\Api\ProfileController::class, 'update'])->name('profiles.update');
    Route::post('profiles/upload-image', [\App\Http\Controllers\Api\ProfileController::class, 'uploadImage'])->name('profiles.upload-image');
    // Work History
    Route::apiResource('work-history', \App\Http\Controllers\Api\WorkHistoryController::class);
    // Post
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class)->only(['index', 'store', 'update', 'destroy']);
    // Upload
    Route::get('uploads/group-type', [\App\Http\Controllers\Api\UploadController::class, 'groupType'])->name('uploads.group-type');
    Route::apiResource('uploads', \App\Http\Controllers\Api\UploadController::class)->only(['index']);
});
