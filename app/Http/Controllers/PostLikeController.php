<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    use APIResponder;

    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();

        $post = Post::findOrFail($request->post_id);

        if($post->likes->where('user_id', $user->id)->first()){

            $post->likes()->where('user_id', $user->id)->delete();

            $post->decrement('likes_count');

            return $this->successResponse($post, 'Post unliked Successfully!');
        }
        $post->likes()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $post->increment('likes_count');

        return $this->successResponse($post, 'Post Liked Successfully!');
    }
}
