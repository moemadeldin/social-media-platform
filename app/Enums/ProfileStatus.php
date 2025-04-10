<?php

declare(strict_types=1);

namespace App\Enums;

enum ProfileStatus: int
{
    case PUBLIC = 1;
    case PRIVATE = 2;

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'public',
            self::PRIVATE => 'private',
        };
    }
}
