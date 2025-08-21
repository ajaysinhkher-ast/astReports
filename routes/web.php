<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])
    ->middleware('verify.shopify')
    ->name('home');


Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->middleware(['verify.shopify'])->name('dashboard');



Route::get('order/report',[HomeController::class, 'order'])->middleware('verify.shopify')->name('order');
// try to customize midleware by using both the verify.shopify and auth middleware.



