<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'profile_picture' => $this->profile_picture,
            'bio' => $this->bio,
            'website' => $this->website,
            'posts' => $this->posts_count,
            'followers' => $this->followers_count,
            'following' => $this->following_count
        ];
    }
}
