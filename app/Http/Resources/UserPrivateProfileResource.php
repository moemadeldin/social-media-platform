<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPrivateProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'This Profile is private',
            'username' => $this->username,
            'full_name' => $this->full_name,
            'profile_picture' => $this->profile_picture,
            'bio' => $this->bio,
            'posts' => $this->posts_count,
            'followers' => $this->followers_count,
            'following' => $this->following_count,
        ];
    }
}
