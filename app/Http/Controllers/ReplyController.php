<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\Request;

class ReplyController extends Controller
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
    public function store(ReplyRequest $request, $postId, $commentId)
    {
        $user = auth()->user();

        $post = Post::findOrFail($postId);

        $comment = Comment::findOrFail($commentId);

        $reply = Reply::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id
        ]));
        $comment->increment('replies_count');

        return $this->successResponse($reply, "Reply added successfully!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReplyRequest $request, $postId, $commentId, $replyId)
    {
        $user = auth()->user();

        $post = Post::findOrFail($postId);

        $comment = Comment::findOrFail($commentId);

        $reply = Reply::findOrFail($replyId);

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
