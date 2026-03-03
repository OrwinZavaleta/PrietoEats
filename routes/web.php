<?php

use App\Http\Controllers\Auth\AdminOrderController;
use App\Http\Controllers\Auth\AdminProductController;
use App\Http\Controllers\Auth\AdminOffersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, "home"])->name("home");

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{i}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/delete/{i}/{j}', [CartController::class, 'delete'])->name('cart.delete');
    Route::delete('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/order', [CartController::class, 'order'])->name('cart.order');
    Route::put('/cart/increase/{i}/{j}', [CartController::class, 'increase'])->name('cart.increase');
    Route::put('/cart/decrease/{i}/{j}', [CartController::class, 'decrease'])->name('cart.decrease');

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
});
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'isAdmin'])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::resource("products", AdminProductController::class);
        Route::resource("offers", AdminOffersController::class);
        Route::resource("orders", AdminOrderController::class);
    });

require __DIR__ . '/auth.php';
