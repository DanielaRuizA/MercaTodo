<?php

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\LoginController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\RegisterController;
use App\Http\Controllers\Api\V1\Product\ProductImportController;
use App\Http\Controllers\Api\V1\Product\ProductController;

Route::name('api.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');
    

    Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
        Route::apiSingleton('profile', ProfileController::class)->destroyable();

        Route::apiResource('products', ProductController::class);
        Route::post('products/import', ProductImportController::class)->name('products.import');
    });
});
