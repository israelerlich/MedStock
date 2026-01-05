<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);

Route::post('/register', [UserController::class, 'store']);

Route::patch('/edit', [UserController::class, 'update']);

Route::delete('/delete/{user_id}', [UserController::class, 'destroy']);



Route::get('/hospitals', [HospitalController::class, 'index']);

Route::post('/register_hospital', [HospitalController::class, 'store']);

Route::patch('/edit/{hospital}', [HospitalController::class, 'update']);

Route::delete('/delete/{hospital}', [HospitalController::class, 'destroy']);
    


Route::get('/suppliers', [SupplierController::class, 'index']);

Route::post('/register_supplier', [SupplierController::class, 'store']);

Route::patch('/edit/{supplier}', [SupplierController::class, 'update']);

Route::delete('delete/{supplier}', [SupplierController::class, 'destroy']);




Route::get('/product', [ProductController::class, 'index']);

Route::post('/register_product', [ProductController::class, 'store']);

Route::patch('/edit/{product}', [ProductController::class, 'update']);

Route::delete('delete/{product}', [ProductController::class, 'destroy']);



Route::get('/product', [])


 




// Route::get();
// Route::post();
// Route::patch();
// Route::put();
// Route::delete();