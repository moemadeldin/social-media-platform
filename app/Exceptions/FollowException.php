<?php

namespace App\Exceptions;

use Exception;

class FollowException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function selfFollow()
    {
        return new self("You cannot follow yourself.");
    }
    public static function selfUnFollow()
    {
        return new self("You cannot unfollow yourself.");
    }

    public static function alreadyFollowed()
    {
        return new self("You are already following this user.");
    }

    public static function notFollowing()
    {
        return new self("You are not following this user.");
    }

    public static function followRequestNotFound()
    {
        return new self("Follow request not found.");
    }
}