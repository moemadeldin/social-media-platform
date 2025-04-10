<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: int
{
    case PREFER_NOT_TO_SAY = 0;
    case MALE = 1;
    case FEMALE = 2;


    public function label(): string
    {
        return match ($this) {
            self::PREFER_NOT_TO_SAY => 'prefer not to say',
            self::MALE => 'male',
            self::FEMALE => 'female',
        };
    }
}
