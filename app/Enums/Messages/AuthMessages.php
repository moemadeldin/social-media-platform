<?php

declare(strict_types=1);

namespace App\Enums\Messages;

enum AuthMessages: string
{
    case REGISTERED = 'Your account has been registered. Please check your email for verification.';
    case VERIFIED = 'Your account has been successfully verified. You can now log in.';

    case LOGGED_IN = 'You have been successfully logged in.';
    case LOGGED_OUT = 'You have been successfully logged out.';
}
