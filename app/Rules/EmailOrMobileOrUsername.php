<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class EmailOrMobileOrUsername implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)  // Email check
            && ! preg_match('/^\d{11}$/', $value)  // Mobile check (11-digit number)
            && ! preg_match('/^[a-zA-Z0-9_-]{3,16}$/', $value)  // Username check (alphanumeric, 3-16 chars)
        ) {
            $fail('The :attribute must be a valid email, mobile number, or username.');
        }
    }
}
