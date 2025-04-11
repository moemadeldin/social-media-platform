<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post' => $this->id,
            'caption' => $this->caption,
            'collaborator' => $this->collaborators,
            'location' => $this->location,
            'visibility' => $this->visibility->label(),
            'likes_count' => $this->likes_count,
            'likes' => $this->likes->pluck('user.username'),
            'comments_count' => $this->comments_count,
            'post_comments' => $this->comments->map(function ($comment) {
                return [
                    $comment->user->username => $comment->comment,
                    'comment_likes_count' => $comment->likes_count,
                    'comment_likes' => $comment->likes->pluck('user.username'),
                    'replies_count' => $comment->replies_count,
                    'replies' => $comment->replies->map(function ($reply) {
                        return [
                            $reply->user->username => $reply->reply,
                            'reply_likes_count' => $reply->likes_count,
                            'reply_likes' => $reply->likes->pluck('user.username'),
                        ];
                    }),
                ];
            }),
        ];
    }
}
