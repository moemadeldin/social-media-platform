<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use APIResponder;
    public function index($username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        return $this->successResponse(PostResource::collection($posts), 'Posts');
    }
    public function store(CreatePostRequest $request): JsonResponse
    {
        $user = auth()->user();

        $post = Post::create(array_merge($request->validated(), ['user_id' => $user->id]));

        $user->increment('posts_count');

        return $this->successResponse($post, "Post created successfully");
    }

    public function update(CreatePostRequest $request, $username, Post $post): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if($post->user_id != $user->id){
            return $this->failedResponse("You cannot update this post");
        }

        $post->update($request->validated());
        
        return $this->successResponse($post, "Post updated successfully!");

    }

    public function destroy($username, Post $post): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if($post->user_id != $user->id){
            return $this->failedResponse("You cannot delete this post");
        }
        
        $post->delete();

        $user->decrement('posts_count');

        return $this->successResponse($post, "Post deleted successfully!");

    }
}
