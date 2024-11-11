<?php

namespace App\Exceptions;

use Exception;

class UserStatusException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function notActiveOrBlocked(): self
    {
        return new self('User is not active or blocked');
    }
}