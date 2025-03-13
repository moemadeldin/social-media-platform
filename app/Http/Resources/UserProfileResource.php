<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'full_name' => $this->full_name,
            'profile_picture' => $this->profile->profile_picture,
            'bio' => $this->profile->bio,
            'website' => $this->profile->website,
            'posts' => $this->stats->posts_count,
            'followers' => $this->stats->followers_count,
            'following' => $this->stats->following_count,
            'followers_list' => $this->followers->pluck('username'),
            'following_list' => $this->following->pluck('username'), 
            'posts_list' => PostResource::collection($this->posts),
        ];
    }
}
