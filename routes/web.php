<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;


Route::middleware(['verify.shopify'])->group(function(){
     Route::get('/',[HomeController::class, 'index'])->name('home');
     Route::get('/order', [HomeController::class, 'order'])->name('order');
});



