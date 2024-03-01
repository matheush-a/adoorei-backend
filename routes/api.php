<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'product'], function() {
    Route::get('/', [ProductController::class, 'index']);
});

Route::group(['prefix' => 'sale'], function() {
    Route::get('/', [SaleController::class, 'index']);
    Route::get('/{id}', [SaleController::class, 'show']);
    Route::patch('/', [SaleController::class, 'cancel']);
    Route::post('/', [SaleController::class, 'store']);
    Route::post('/add-products', [SaleController::class, 'addProducts']);
});