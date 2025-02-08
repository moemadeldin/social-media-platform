<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\EmailOrMobile;
use Illuminate\Foundation\Http\FormRequest;

final class VerifyRequest extends FormRequest
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
            'email_or_mobile' => ['required', 'string', new EmailOrMobile],
            'code' => ['required', 'digits:4', 'exists:users,verification_code'],
        ];
    }
}
