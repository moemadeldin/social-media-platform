<?php

namespace App\Enums;

enum FollowStatus: int
{
    case PENDING = 0;
    case ACCEPTED = 1;
}