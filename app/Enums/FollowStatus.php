<?php

declare(strict_types=1);

namespace App\Enums;

enum FollowStatus: int
{
    case PENDING = 0;
    case ACCEPTED = 1;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::ACCEPTED => 'accepted',
        };
    }
}
