<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostMediaController;
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
    Route::get('/users/{username}/posts', [PostController::class, 'index']);


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
        
        Route::controller(PostController::class)->group(function () {
            Route::post('/users/{username}/posts', 'store');
            Route::put('/users/{username}/posts/{post}', 'update');
            Route::delete('/users/{username}/posts/{post}', 'destroy');
        });
        Route::controller(PostMediaController::class)->group(function () {
            Route::post('/users/{username}/posts/{post}/media', 'store');
            Route::post('/users/{username}/posts/{post}/media', 'update');
            Route::delete('/users/{username}/posts/{post}/media', 'destroy');
        });

        Route::controller(PostCommentController::class)->group(function () {
            Route::post('/users/{username}/posts/{post_id}/comment', 'store');
            Route::put('/users/{username}/posts/{post_id}/comment/{comment_id}', 'update');
            Route::delete('/users/{username}/posts/{post_id}/comment/{comment_id}', 'destroy');
        });
        Route::controller(PostLikeController::class)->group(function () {
            Route::post('/users/{username}/posts/{post_id}/like', 'store');
        });

    });