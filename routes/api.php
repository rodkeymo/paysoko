<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;


Route::get('/products', [ProductController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
Route::get('/cart/items', [CartController::class, 'viewCart']);
Route::post('/orders/place', [OrderController::class, 'placeOrder']);
Route::get('/orders', [OrderController::class, 'index']);