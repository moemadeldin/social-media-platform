<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CommentController extends Controller
{
    use APIResponder;

    public function store(CreateCommentRequest $request): JsonResponse
    {
        $user = auth()->user();

        $postToComment = Post::findOrFail($request->post_id);

        $comment = Comment::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'post_id' => $postToComment->id,
        ]));

        $postToComment->increment('comments_count');

        return $this->successResponse($comment, 'Commented Successfully!');
    }

    public function update(CreateCommentRequest $request): JsonResponse
    {

        $comment = Comment::findOrFail($request->comment_id);

        $comment->update($request->validated());

        return $this->successResponse($comment, 'Comment Updated Successfully!');

    }

    public function destroy(Request $request): JsonResponse
    {
        $post = Post::findOrFail($request->post_id);

        $comment = Comment::findOrFail($request->comment_id);

        $comment->delete();

        $post->decrement('comments_count');

        return $this->successResponse($comment, 'Comment deleted Successfully!');
    }
}
