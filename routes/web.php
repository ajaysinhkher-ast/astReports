<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;


// Route::get('/', function () {
//     return Inertia::render('welcome');
// })->middleware('verify.shopify')->name('home');

// Route::get('/', [HomeController::class, 'index'])
//     ->name('home');

// Route::get('/order', [HomeController::class, 'order'])->name('order');;

// Route::middleware([AuthShopifyOrSanctum::class])->group(function () {
    // Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/order', [HomeController::class, 'order'])->name('order');
// });

Route::middleware(['verify.shopify'])->group(function(){
     Route::get('/',[HomeController::class, 'index'])->name('home');
     Route::get('/order', [HomeController::class, 'order'])->name('order');
});
// R;oute::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
// });

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
