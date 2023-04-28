<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('changeStatus', [App\Http\Controllers\Admin\UserController::class, 'changeStatus'])->name('changeStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::get('changeProductStatus', [App\Http\Controllers\Admin\ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('stores', App\Http\Controllers\Store\StoreController::class);
});
