<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['throttle:5,1'])
    ->controller(AuthController::class)
    ->group(function () {

        Route::post('/register', 'register');

        Route::post('/login', 'login');

        Route::post('/forget-password', 'forgetPassword');

        Route::post('/check-verification-code', 'checkVerificationCode');
    });

    Route::middleware('auth:api')->group(function () {

        // Authentication routes
    
        Route::controller(AuthController::class)->group(function () {
            Route::post('/register/verification/', 'verify')->middleware('throttle:5,1');
            Route::post('/reset-password', 'resetPassword')->middleware('throttle:5,1');
            Route::post('/logout', 'logout');
        });
    });