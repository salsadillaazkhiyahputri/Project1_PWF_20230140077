<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->middleware(['auth', 'verified'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Product Page
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');

    Route::get('/product/view/{product}', [ProductController::class, 'show'])->name('product.show'); 
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
});
require __DIR__.'/auth.php';

