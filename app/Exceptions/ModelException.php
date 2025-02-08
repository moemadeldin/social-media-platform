<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ModelException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function modelIsNotFound()
    {
        return new self('Model is not found.');
    }
}
