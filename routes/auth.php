<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowRequestController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function (): void {

    Route::controller(AuthController::class)->group(function (): void {
        Route::post('/check-verification-code', 'checkVerificationCode');
        Route::post('/register/verification/', 'verify');
        Route::post('/reset-password', 'resetPassword')->middleware('throttle:5,1');
        Route::post('/logout', 'logout');
    });

    Route::controller(ProfileController::class)->group(function (): void {
        Route::get('/{username}', 'index');
        Route::put('/accounts/edit', 'update');
        Route::post('/accounts/edit', 'update');
        Route::delete('/accounts/edit', 'destroy');
    });

    Route::controller(UserProfileController::class)->group(function (): void {
        Route::post('/{username}/follow', 'store');
        Route::delete('/{username}/unfollow', 'destroy');
    });
    Route::controller(FollowRequestController::class)->group(function (): void {
        Route::get('/follow-requests', 'pendingFollowRequests');
        Route::post('/follow-requests/{username}/accept', 'store');
        Route::post('/follow-requests/{username}/decline', 'destroy');
    });

    Route::controller(PostController::class)->group(function (): void {
        Route::get('/my-posts', 'index');
        Route::post('/{username}/posts', 'store');
        Route::put('/{username}/posts/{post}', 'update');
        Route::delete('/{username}/posts/{post}', 'destroy');
    });
    Route::controller(MediaController::class)->group(function (): void {
        Route::post('/{username}/posts/{post}/media', 'store');
        Route::post('/{username}/posts/{post}/media', 'update');
        Route::delete('/{username}/posts/{post}/media', 'destroy');
    });
    Route::controller(CommentController::class)->group(function (): void {
        Route::post('/{username}/posts/{post_id}/comment', 'store');
        Route::put('/{username}/posts/{post_id}/comment/{comment_id}', 'update');
        Route::delete('/{username}/posts/{post_id}/comment/{comment_id}', 'destroy');
    });
    Route::controller(ReplyController::class)->group(function (): void {
        Route::post('/{postId}/comments/{commentId}/replies', 'store');
        Route::put('/{postId}/comments/{commentId}/replies/{replyId}', 'update');
        Route::delete('/{postId}/comments/{commentId}/replies/{replyId}', 'destroy');
        Route::delete('/{username}/post/{postId}/comments/{commentId}/replies/{replyId}', 'destroy');
    });
    Route::controller(LikeController::class)->group(function (): void {
        Route::post('/like/{model}/{id}', 'store');
    });
    Route::controller(StoryController::class)->group(function (): void {
        Route::get('/{username}/stories', 'index');
        Route::post('/{username}/story', 'store');
        Route::delete('/{username}/stories/{story}', 'destroy');
    });
    Route::controller(NoteController::class)->group(function (): void {
        Route::get('/{username}/notes', 'index');
        Route::post('/{username}/note', 'store');
        Route::delete('/{username}/notes/{note}', 'destroy');
    });
});
