<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaType: int
{
    case IMAGE = 1;
    case VIDEO = 2;
    case FILE = 3;

    public function label(): string
    {
        return match ($this) {
            self::IMAGE => 'image',
            self::VIDEO => 'video',
            self::FILE => 'file',
        };
    }
}
