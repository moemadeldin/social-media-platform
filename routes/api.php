<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * 
 * database 
 * users
 * posts
 * posts_media
 * post_comment
 * post_likes
 * saved_posts
 * followers
 * following
 * groups
 * conversations
 * messages
 * messages_attachments
 */