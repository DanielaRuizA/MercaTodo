<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\AdminPanel\UserController;
use App\Http\Controllers\AdminPanel\ProductController;

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
    Route::resource('users', UserController::class);
    Route::get('change/user/status', [UserController::class, 'changeUserStatus'])->name('change.user.status');

    Route::resource('products', ProductController::class);
    Route::get('change/product/status', [ProductController::class, 'changeProductStatus'])->name('change.product.status');
});

Route::middleware(['auth'])->group(function () {
    Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('stores/{product}', [StoreController::class, 'show'])->name('stores.show');

    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('cart/{product}', [CartController::class, 'update'])->name('cart.update');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::post('payments', [PaymentController::class, 'processPayment'])->name('payments.process');
    Route::get('payments/payment/response', [PaymentController::class, 'processResponse'])->name('payments.process.response');
    Route::patch('payments/retry/payment/', [PaymentController::class, 'retryPayment'])->name('payments.retry.payment');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
});
