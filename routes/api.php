<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowRequestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
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
        Route::controller(FollowRequestController::class)->group(function () {
            Route::post('/follow-requests/{username}/accept', [FollowRequestController::class, 'store']);
            Route::post('/follow-requests/{username}/decline', [FollowRequestController::class, 'destroy']);
            // Route::get('/pending-follow-requests', [FollowRequestController::class, 'pending']);
        });
        
        Route::controller(PostController::class)->group(function () {
            Route::post('/users/{username}/posts', 'store');
            Route::put('/users/{username}/posts/{post}', 'update');
            Route::delete('/users/{username}/posts/{post}', 'destroy');
        });
        Route::controller(MediaController::class)->group(function () {
            Route::post('/users/{username}/posts/{post}/media', 'store');
            Route::post('/users/{username}/posts/{post}/media', 'update');
            Route::delete('/users/{username}/posts/{post}/media', 'destroy');
        });

        Route::controller(CommentController::class)->group(function () {
            Route::post('/users/{username}/posts/{post_id}/comment', 'store');
            Route::put('/users/{username}/posts/{post_id}/comment/{comment_id}', 'update');
            Route::delete('/users/{username}/posts/{post_id}/comment/{comment_id}', 'destroy');
        });
        Route::controller(ReplyController::class)->group(function () {
            Route::post('/posts/{postId}/comments/{commentId}/replies', 'store'); 
            Route::put('/posts/{postId}/comments/{commentId}/replies/{replyId}', 'update'); 
            Route::delete('/posts/{postId}/comments/{commentId}/replies/{replyId}', 'destroy'); 
            Route::delete('/user/{username}/post/{postId}/comments/{commentId}/replies/{replyId}', 'destroy');
        });
        Route::controller(LikeController::class)->group(function () {
            Route::post('/like/{model}/{id}', 'store');
        });
        Route::controller(StoryController::class)->group(function () {
            Route::get('/user/{username}/stories', 'index');        
            Route::post('/user/{username}/story', 'store');        
            Route::delete('/user/{username}/stories/{story}', 'destroy');        
        });
        Route::controller(NoteController::class)->group(function () {
            Route::get('/user/{username}/notes', 'index');        
            Route::post('/user/{username}/note', 'store');
            Route::delete('/user/{username}/notes/{note}', 'destroy');        
        });
    });