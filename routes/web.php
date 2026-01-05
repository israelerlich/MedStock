<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);

Route::post('/register', [UserController::class, 'store']);

Route::patch('/edit', [UserController::class, 'update']);

Route::delete('/delete/{user_id}', [UserController::class, 'destroy']);

// Route::get();
// Route::post();
// Route::patch();
// Route::put();
// Route::delete();