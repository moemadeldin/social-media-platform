<?php

namespace App\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;
}
