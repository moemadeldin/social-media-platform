<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

final class AuthRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }
    public function findUserByEmailOrMobileOrUsername(array $data): User
    {
    return User::where('mobile', $data['mobile'])
                ->orWhere('username', $data['username'])
                ->orWhere('email', $data['email'])
                ->firstOrFail();
    }
    public function findUserByEmailOrMobileWithCode(array $data): User
    {
        return User::where(function ($query) use ($data): void {
            $query->where('email', $data['email_or_mobile'])
                ->orWhere('mobile', $data['email_or_mobile']);
        })
            ->where('verification_code', $data['code'])
            ->firstOrFail();
    }
}
