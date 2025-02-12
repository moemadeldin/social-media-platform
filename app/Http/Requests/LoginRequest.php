<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\EmailOrMobileOrUsername;
use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_or_mobile_or_username' => ['required', 'string', new EmailOrMobileOrUsername],
            'password' => ['required', 'min:6', 'max:15', 'regex:/[a-zA-Z]/'],
        ];
    }
}
