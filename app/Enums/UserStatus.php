<?php

declare(strict_types=1);

namespace App\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;
    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'inactive',
            self::ACTIVE => 'active',
            self::BLOCKED => 'blocked',
        };
    }
}
