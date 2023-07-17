<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Product\ProductImportController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');

    Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
        Route::apiSingleton('profile', ProfileController::class)->destroyable();

        Route::apiResource('products', ProductController::class);
        Route::post('products/import', ProductImportController::class)->name('products.import');
    });
});
