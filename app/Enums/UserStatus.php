<?php

namespace App\Enums;

enum UserStatus: string
{
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
}
