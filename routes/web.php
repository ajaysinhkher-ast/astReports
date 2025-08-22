<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;

Route::middleware('verify.shopify')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('reports', [HomeController::class, 'reports'])->name('reports');

    Route::get('orders', [OrdersController::class, 'orders'])->name('orders');
    Route::get('orders/items',[OrdersController::class,'orderItems'])->name('order.items');
    
});
