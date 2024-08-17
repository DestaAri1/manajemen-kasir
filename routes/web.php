<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/dashboard', [HomeController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::post('/', [ProductController::class, 'store'])->name('product.post');
        Route::get('/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/update/{id}', [ProductController::class, 'update'])->name('product.change');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    });
    Route::prefix('/history')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('history');
    });
    Route::prefix('/promo')->group(function () {
        Route::get('/', [PromoController::class, 'index'])->name('promo');
        Route::get('/create', [PromoController::class, 'create'])->name('promo.create');
        Route::post('/', [PromoController::class, 'store'])->name('promo.post');
        Route::get('/{id}', [PromoController::class, 'edit'])->name('promo.edit');
        Route::patch('/{id}', [PromoController::class, 'update'])->name('promo.updated');
        Route::delete('/{id}', [PromoController::class, 'destroy'])->name('promo.delete');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
