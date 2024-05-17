<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// IMPORT CONTROLLERS and MIDDLEWARE
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\Auth;
use App\Http\Controllers\API\Math;

Route::GET('_docs', function () {
    return response()->json([
        'message' => 'Welcome to Laravel API Documentation.'
    ]);
});


//Route::POST('math', [Math::class, 'pembagian'])->name('math');

//
//Route::prefix('v1')->group(function () {
//    Route::POST('login', [AuthController::class, 'login'])->name('login');
//    Route::POST('users/add', [UserController::class, 'add'])->name('users-add');
//    Route::middleware([Auth::class])->group(function () {
//        Route::GET('users', [UserController::class, 'all'])->name('users-all');
//    });
//});
