<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

final class PostController extends Controller
{
    use APIResponder;

    public function index(User $user): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $posts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse(PostResource::collection($posts), 'Posts');
    }

    public function store(CreatePostRequest $request): JsonResponse
    {
        $user = auth()->user();

        $post = $user->posts()->create($request->validated());

        $user->stats()->increment('posts_count');

        return $this->successResponse($post, 'Post created successfully');
    }

    public function update(UpdatePostRequest $request, User $user, Post $post): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $post->update($request->validated());

        return $this->successResponse($post, 'Post updated successfully!');
    }

    public function destroy(UpdatePostRequest $request, User $user, Post $post): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $post->delete();

        $user->stats()->decrement('posts_count');

        return $this->successResponse($post, 'Post deleted successfully!');

    }
}
