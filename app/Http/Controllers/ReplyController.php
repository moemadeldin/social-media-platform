<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

final class ReplyController extends Controller
{
    use APIResponder;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReplyRequest $request, User $user, Post $post, Comment $comment): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $reply = $comment->replies()->create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $request->safe()->content,
        ]);

        $comment->increment('replies_count');

        return $this->successResponse($reply, 'Reply added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ReplyRequest $request,
        User $user, Post $post,
        Comment $comment,
        Reply $reply
        ): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $reply->update($request->validated());

        return $this->successResponse($reply, 'Reply updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, $commentId, $replyId)
    {
        $user = auth()->user();

        $post = Post::findOrFail($postId);

        $comment = Comment::findOrFail($commentId);

        $reply = Reply::findOrFail($replyId);

        $reply->delete();

        return $this->successResponse($reply, 'Reply deleted successfully!');
    }
}
