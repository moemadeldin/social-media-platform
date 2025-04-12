<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CommentController extends Controller
{
    use APIResponder;

    public function store(CreateCommentRequest $request, User $user, Post $post): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $comment = $post->comments()->create([
            'content' => $request->safe()->content,
            'user_id' => auth()->id()
        ]);

        $post->increment('comments_count');

        return $this->successResponse($comment, 'Commented Successfully!');
    }

    public function update(CreateCommentRequest $request, User $user, Post $post, Comment $comment): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $comment->update($request->validated());

        return $this->successResponse($comment, 'Comment Updated Successfully!');

    }

    public function destroy(User $user, Post $post, Comment $comment): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        if(auth()->id() !== $post->user_id && auth()->id() !== $comment->user_id) 
        {
            return $this->failedResponse('No Permission');
        }

        $comment->delete();

        $post->decrement('comments_count');

        return $this->successResponse($comment, 'Comment deleted Successfully!');
    }
}
