<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileResource extends JsonResource
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
            'email' => $this->email,
            'profile_picture' => $this->profile->profile_picture,
            'gender' => $this->profile->gender->label(),
            'bio' => $this->profile->bio,
            'website' => $this->profile->website,
            'mobile' => $this->profile->mobile,
        ];
    }
}
