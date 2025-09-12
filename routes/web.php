<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TowingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AdminController;

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
// Category Data (Public Access)
// ===============================
Route::get('/fetch-categories', [CategoryController::class, 'fetchCategories'])->name('categories.fetch');
Route::get('/categories-partial', [CategoryController::class, 'headerPartial'])->name('categories.partial');

// ===============================
// Authentication
// ===============================

// Client
Route::prefix('client')->group(function () {
    Route::get('/login', [AuthController::class, 'showClientLogin'])->name('client.login');
    Route::post('/login', [AuthController::class, 'loginClient'])->name('client.login.submit');
    Route::get('/register', [AuthController::class, 'showClientRegister'])->name('client.register');
    Route::post('/register', [AuthController::class, 'registerClient'])->name('client.register.submit');
});

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');
});

// Driver
Route::prefix('driver')->group(function () {
    Route::get('/login', [AuthController::class, 'showDriverLogin'])->name('driver.login');
    Route::post('/login', [AuthController::class, 'loginDriver'])->name('driver.login.submit');
    Route::get('/register', [AuthController::class, 'showDriverRegister'])->name('driver.register');
    Route::post('/register', [AuthController::class, 'registerDriver'])->name('driver.register.submit');
});

// ===============================
// Logout
// ===============================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// Category Management
// ===============================
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{id}', [CategoryController::class, 'show'])
        ->whereNumber('id')
        ->name('categories.show');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    });
});

// ===============================
// Payment (M-Pesa Integration)
// ===============================
Route::prefix('payment')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('payment.index');
    Route::get('/{towingId}', [TransactionController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/initiate/{towingId}', [TransactionController::class, 'initiateMpesa'])->name('payment.initiate');
    Route::post('/callback', [TransactionController::class, 'mpesaCallback'])->name('payment.callback');

    Route::get('/success', [TransactionController::class, 'success'])->name('payment.success');
    Route::get('/failed', [TransactionController::class, 'failed'])->name('payment.failed');
});

// ===============================
// Price Calculation
// ===============================
Route::get('/calculate-price', [PriceController::class, 'calculate'])->name('price.calculate');

// ===============================
// Authenticated Routes
// ===============================
Route::middleware(['auth', 'role:client'])->prefix('client')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'client'])->name('client.dashboard');

    Route::get('/towing', [TowingController::class, 'index'])->name('towing.index');
    Route::get('/towing/create', [TowingController::class, 'create'])->name('towing.create');
    Route::post('/towing', [TowingController::class, 'store'])->name('towing.store');
    Route::delete('/towing/{id}', [TowingController::class, 'destroy'])->name('towing.destroy');

    // Instead of marking as Paid directly, redirect to payment form
    Route::post('/towing/{id}/pay', [TowingController::class, 'pay'])->name('towing.pay');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/requests', [TowingController::class, 'adminIndex'])->name('admin.requests.index');
    Route::get('/requests/{id}', [TowingController::class, 'show'])->name('admin.requests.show');
    Route::post('/requests/{id}/assign', [TowingController::class, 'assignDriver'])->name('admin.requests.assign');
    Route::post('/requests/{id}/approve', [TowingController::class, 'approve'])->name('admin.requests.approve');
    Route::post('/requests/{id}/reject', [TowingController::class, 'reject'])->name('admin.requests.reject');

    Route::get('/drivers', [AdminController::class, 'drivers'])->name('admin.drivers.index');
    Route::post('/drivers/{id}/approve', [AdminController::class, 'approveDriver'])->name('admin.drivers.approve');
    Route::post('/drivers/{id}/reject', [AdminController::class, 'rejectDriver'])->name('admin.drivers.reject');
});

Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::post('/requests/{id}/accept', [DriverController::class, 'acceptRequest'])->name('driver.requests.accept');
    Route::post('/requests/{id}/start', [DriverController::class, 'startRequest'])->name('driver.requests.start');
    Route::post('/requests/{id}/complete', [DriverController::class, 'completeRequest'])->name('driver.requests.complete');
});
