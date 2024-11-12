<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'visibility' => $this->visibility,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'likes' => $this->likes->pluck('user.username'),
            'comments' => $this->comments->pluck('user.username', 'comment')
        ];
    }
}
