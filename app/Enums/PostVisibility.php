<?php

declare(strict_types=1);

namespace App\Enums;

enum PostVisibility: int
{
    case HIDE = 0;
    case VISIBLE = 1;
}
