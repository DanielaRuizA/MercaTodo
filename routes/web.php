<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\AdminPanel\UserController;
use App\Http\Controllers\AdminPanel\ProductController;
use App\Http\Controllers\AdminPanel\ReportOrderController;
use App\Http\Controllers\AdminPanel\ProductExportController;
use App\Http\Controllers\AdminPanel\ProductImportController;
use App\Http\Controllers\AdminPanel\ProductsStockReportController;

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
    
    Route::get('/', function () {
        return redirect()->route('stores.index');
    });
});

Route::get('user/banned', function () {
    return Inertia::render('Auth/UserBanned');
})->name('user.banned');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/stores');
    
//     Route::get('/', function () {
//         return redirect()->route('stores.index');
//     });
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
    
//     Route::get('/', function () {
//         return redirect()->route('dashboard');
//     });
// });


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('change/user/status', [UserController::class, 'changeUserStatus'])->name('change.user.status');

    Route::get('products/imports', [ProductImportController::class,'show'])->name('products.show.imports');
    Route::post('products/imports', [ProductImportController::class,'store'])->name('products.store.imports');

    Route::get('products/exports', ProductExportController::class)->name('products.export');
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
    Route::patch('payments/retry/payment', [PaymentController::class, 'retryPayment'])->name('payments.retry');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/report', [ReportOrderController::class, 'ordersReportTable'])->name('orders.report.table');
    Route::post('orders/report/export', [ReportOrderController::class, 'ordersReportExport'])->name('orders.report.export');
});
