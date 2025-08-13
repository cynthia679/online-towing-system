<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('category')->group(function () {
        Route::post('index', [App\Http\Controllers\CategoryController::class, 'index']);
        Route::post('create', [App\Http\Controllers\CategoryController::class, 'create']);
        Route::post('update', [App\Http\Controllers\CategoryController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\CategoryController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\CategoryController::class, 'findById']);
    });

    Route::prefix('location')->group(function () {
        Route::post('index', [App\Http\Controllers\LocationController::class, 'index']);
        Route::post('create', [App\Http\Controllers\LocationController::class, 'create']);
        Route::post('update', [App\Http\Controllers\LocationController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\LocationController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\LocationController::class, 'findById']);
    });

    Route::prefix('client')->group(function () {
        Route::post('create', [App\Http\Controllers\ClientController::class, 'create']);
        Route::post('update', [App\Http\Controllers\ClientController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\ClientController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\ClientController::class, 'findById']);
    });

    Route::prefix('product')->group(function () {
        Route::post('create', [App\Http\Controllers\ProductController::class, 'create']);
        Route::post('update', [App\Http\Controllers\ProductController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\ProductController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\ProductController::class, 'findById']);
    });

    Route::prefix('transaction')->group(function () {
        Route::post('create', [App\Http\Controllers\TransactionController::class, 'create']);
        Route::post('update', [App\Http\Controllers\TransactionController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\TransactionController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\TransactionController::class, 'findById']);
    });

    Route::prefix('user')->group(function () {
        Route::post('create', [App\Http\Controllers\UserController::class, 'create']);
        Route::post('update', [App\Http\Controllers\UserController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\UserController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\UserController::class, 'findById']);
    });

    Route::prefix('setting')->group(function () {
        Route::post('create', [App\Http\Controllers\SettingController::class, 'create']);
        Route::post('update', [App\Http\Controllers\SettingController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\SettingController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\SettingController::class, 'findById']);
    });

    Route::prefix('customer-request')->group(function () {
        Route::post('create', [App\Http\Controllers\CustomerRequestController::class, 'create']);
        Route::post('update', [App\Http\Controllers\CustomerRequestController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\CustomerRequestController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\CustomerRequestController::class, 'findById']);
    });

    Route::prefix('order')->group(function () {
        Route::post('create', [App\Http\Controllers\OrderController::class, 'create']);
        Route::post('update', [App\Http\Controllers\OrderController::class, 'update']);
        Route::post('delete', [App\Http\Controllers\OrderController::class, 'deleteById']);
        Route::post('findById', [App\Http\Controllers\OrderController::class, 'findById']);
    });

});
