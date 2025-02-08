<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaType: int
{
    case IMAGE = 1;
    case VIDEO = 2;
    case FILE = 3;
}
