<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// public endpoints

Route::middleware(['throttle:5,1'])
    ->controller(AuthController::class)
    ->group(function () {

        Route::post('/register', 'register');

        Route::post('/login', 'login');

        Route::post('/forget-password', 'forgetPassword');

        Route::post('/check-verification-code', 'checkVerificationCode');

    });
    Route::get('/users/{username}', [UserProfileController::class, 'index']);

    Route::middleware('auth:api')->group(function () {

        // Authentication routes
    
        Route::controller(AuthController::class)->group(function () {
            Route::post('/register/verification/', 'verify')->middleware('throttle:5,1');
            Route::post('/reset-password', 'resetPassword')->middleware('throttle:5,1');
            Route::post('/logout', 'logout');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profiles', 'index');
            Route::post('/profiles/{username}', 'update');
            Route::delete('/profiles/{username}', 'destroy');
        });
        
        Route::controller(UserProfileController::class)->group(function () {
            Route::post('/users/{username}/follow', 'store');
            Route::post('/users/{username}/unfollow', 'destroy');
        });
    });