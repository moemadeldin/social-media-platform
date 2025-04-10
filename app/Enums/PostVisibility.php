<?php

declare(strict_types=1);

namespace App\Enums;

enum PostVisibility: int
{
    case HIDE = 0;
    case VISIBLE = 1;

    public function label(): string
    {
        return match ($this) {
            self::HIDE => 'hide',
            self::VISIBLE => 'visible',
        };
    }
}
