<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;


Route::middleware(['verify.shopify'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('orders', [HomeController::class, 'order'])->name('order');
    Route::get('orderItems', [HomeController::class, 'orderItems'])->name('orderItems');
});






