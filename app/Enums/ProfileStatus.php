<?php

declare(strict_types=1);

namespace App\Enums;

enum ProfileStatus: int
{
    case PUBLIC = 1;
    case PRIVATE = 2;
}
