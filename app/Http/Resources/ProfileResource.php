<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'profile_picture' => $this->profile_picture,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'website' => $this->website,
            'mobile' => $this->mobile,
        ];
    }
}
