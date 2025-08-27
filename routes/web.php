<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomReportController;
use App\Http\Controllers\OrdersController;

Route::middleware('verify.shopify')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('reports/custom', [CustomReportController::class, 'index'])->name('reports.custom.show');
    Route::post('reports/custom', [CustomReportController::class, 'customReports'])->name('reports.custom');

    Route::get('orders', [OrdersController::class, 'orders'])->name('orders');
    Route::get('orders/filter', [OrdersController::class, 'filter'])->name('orders.filter');


    Route::get('orders/items',[OrdersController::class,'orderItems'])->name('order.items');


    //
    Route::get('reports/orders',[CustomReportController::class,'orderReports'])->name('reports.orders');
});
