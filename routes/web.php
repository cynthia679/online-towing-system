<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ===============================
// ✅ Static Pages
// ===============================
Route::view('/', 'home')->name('home');
Route::view('/welcome', 'welcome')->name('welcome');

// ===============================
// ✅ Category Data Routes
// ===============================
Route::get('/fetch-categories', [CategoryController::class, 'fetchCategories'])->name('categories.fetch');
Route::get('/categories-partial', [CategoryController::class, 'headerPartial'])->name('categories.partial');

// ===============================
// ✅ Client Authentication
// ===============================
Route::get('/client-login', [AuthController::class, 'showClientLogin'])->name('client.login');
Route::post('/client-login', [AuthController::class, 'loginClient'])->name('client.login.submit');

Route::get('/client-register', [AuthController::class, 'showClientRegister'])->name('client.register');
Route::post('/client-register', [AuthController::class, 'registerClient'])->name('client.register.submit');

// ===============================
// ✅ Admin Authentication
// ===============================
Route::get('/admin-login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');

// ===============================
// ✅ Driver Authentication
// ===============================
Route::get('/driver-login', [AuthController::class, 'showDriverLogin'])->name('driver.login');
Route::post('/driver-login', [AuthController::class, 'loginDriver'])->name('driver.login.submit');

// ===============================
// ✅ Logout
// ===============================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// ✅ Category Management
// ===============================
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// ===============================
// ✅ Dashboard
// ===============================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
