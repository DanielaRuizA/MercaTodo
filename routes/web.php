<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', App\Http\Controllers\AdminPanel\UserController::class);
    Route::get('changeStatus', [App\Http\Controllers\AdminPanel\UserController::class, 'changeStatus'])->name('changeStatus');
    Route::resource('products', App\Http\Controllers\AdminPanel\ProductController::class);
    Route::get('changeProductStatus', [App\Http\Controllers\AdminPanel\ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/stores', [App\Http\Controllers\Store\StoreController::class, 'index'])->name('stores.index');
    Route::get('stores/{product}', [App\Http\Controllers\Store\StoreController::class, 'show'])->name('stores.show');
});
