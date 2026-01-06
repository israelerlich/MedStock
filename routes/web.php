<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
}); 

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('hospitals', HospitalController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('product-movements', ProductMovementController::class);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
        Route::get('/movements', [ReportController::class, 'movements'])->name('movements');
        Route::get('/expiry', [ReportController::class, 'expiry'])->name('expiry');
        Route::get('/demand', [ReportController::class, 'demand'])->name('demand');
        Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
    });

    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('dashboard');
        Route::get('/expenses-by-category', [FinanceController::class, 'expensesByCategory'])->name('expenses-by-category');
        Route::get('/monthly-report', [FinanceController::class, 'monthlyReport'])->name('monthly-report');
        Route::put('/hospitals/{hospital}/budget', [FinanceController::class, 'updateBudget'])->name('update-budget');
    });
});

