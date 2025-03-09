<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserBuyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function() {
    Route::get('/', function() {
        return view('index');
    });
    Route::get('/login', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class,'store']);
});

Route::middleware(['auth'])->group(function() {
    Route::get('/logout', [SessionController::class, 'destroy'])->name('logout');
    Route::resource('/products', \App\Http\Controllers\ProductController::class);
    Route::post('/products/{id}/purchase', [ProductController::class, 'purchase'])->name('products.purchase');
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserBuyController::class, 'index'])->name('dashboard');
});
