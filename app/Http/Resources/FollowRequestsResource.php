<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class FollowRequestsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'follower' => [
                'username' => $this->follower->username,
                'full_name' => $this->follower->full_name,
                'profile_picture' => $this->follower->profile_picture,
            ],
            'status' => $this->status,
        ];
    }
}
