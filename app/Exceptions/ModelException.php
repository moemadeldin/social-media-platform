<?php

namespace App\Exceptions;

use Exception;

class ModelException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function modelIsNotFound()
    {
        return new self("Model is not found.");
    }
}