<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TowingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PriceController;

// ===============================
// Default Login
// ===============================
Route::get('/login', [AuthController::class, 'showClientLogin'])->name('login');

// ===============================
// Static Pages
// ===============================
Route::view('/', 'home')->name('home');
Route::view('/welcome', 'welcome')->name('welcome');

// ===============================
// Category Data
// ===============================
Route::get('/fetch-categories', [CategoryController::class, 'fetchCategories'])->name('categories.fetch');
Route::get('/categories-partial', [CategoryController::class, 'headerPartial'])->name('categories.partial');

// ===============================
// Authentication
// ===============================
Route::prefix('client')->group(function () {
    Route::get('/login', [AuthController::class, 'showClientLogin'])->name('client.login');
    Route::post('/login', [AuthController::class, 'loginClient'])->name('client.login.submit');
    Route::get('/register', [AuthController::class, 'showClientRegister'])->name('client.register');
    Route::post('/register', [AuthController::class, 'registerClient'])->name('client.register.submit');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');
});

Route::prefix('driver')->group(function () {
    Route::get('/login', [AuthController::class, 'showDriverLogin'])->name('driver.login');
    Route::post('/login', [AuthController::class, 'loginDriver'])->name('driver.login.submit');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// Category Management
// ===============================
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
});

// ===============================
// Payment (M-Pesa Integration)
// ===============================
Route::prefix('payment')->group(function () {
    // Standalone payment index page (must come first)
    Route::get('/', [TransactionController::class, 'index'])->name('payment.index');

    // Payment form by towing ID
    Route::get('/{towingId}', [TransactionController::class, 'showPaymentForm'])->name('payment.form');

    // Initiate STK Push
    Route::post('/initiate/{towingId}', [TransactionController::class, 'initiateMpesa'])->name('payment.initiate');

    // Safaricom Callback
    Route::post('/callback', [TransactionController::class, 'mpesaCallback'])->name('payment.callback');

    // Success / Failed pages
    Route::get('/success', [TransactionController::class, 'success'])->name('payment.success');
    Route::get('/failed', [TransactionController::class, 'failed'])->name('payment.failed');

    // Check payment status
    Route::get('/status/{id}', [TransactionController::class, 'status'])->name('payment.status');
});

// ===============================
// Price Calculation
// ===============================
Route::get('/calculate-price', [PriceController::class, 'calculate'])->name('price.calculate');

// ===============================
// Authenticated Routes (Dashboards & Towing)
// ===============================
Route::middleware('auth')->group(function () {

    // Client
    Route::prefix('client')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'client'])->name('client.dashboard');

        // ✅ Added towing.index route
        Route::get('/towing', [TowingController::class, 'index'])->name('towing.index');
        Route::get('/towing/create', [TowingController::class, 'create'])->name('towing.create');
        Route::post('/towing', [TowingController::class, 'store'])->name('towing.store');
    });

    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    // Driver
    Route::prefix('driver')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'driver'])->name('driver.dashboard');
    });
});
