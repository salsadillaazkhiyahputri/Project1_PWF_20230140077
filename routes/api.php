<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController as ProductApi; 
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

// 1. Route Login
Route::post('/login', [AuthController::class, 'getToken']);

// 2. Route yang WAJIB Login
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- API PRODUCT (TUGAS) ---
   
    Route::get('/product', [ProductApi::class, 'index']); 
    Route::post('/product', [ProductApi::class, 'store']); 
    Route::get('/product/{id}', [ProductApi::class, 'show']); 
    Route::put('/product/{id}', [ProductApi::class, 'update']); 
    Route::delete('/product/{id}', [ProductApi::class, 'destroy']); 

    // --- API CATEGORY (TUGAS) ---
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

});