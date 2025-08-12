<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return Inertia::render('welcome');
// })->middleware('verify.shopify')->name('home');

Route::get('/', [HomeController::class, 'index'])
    ->middleware('verify.shopify')
    ->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
