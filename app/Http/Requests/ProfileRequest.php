<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ProfileStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ProfileRequest extends FormRequest
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
            'username' => ['nullable', 'string', 'unique:users,username'],
            'full_name' => ['nullable', 'string'],
            'current_password' => ['nullable', 'min:6', 'max:15', 'regex:/[a-zA-Z]/'],
            'password' => ['nullable', 'confirmed', 'min:6', 'max:15', 'regex:/[a-zA-Z]/'],
            'email' => ['nullable', 'email:rfc,dns', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'max:11', 'unique:users,mobile'],
            'bio' => ['nullable', 'string'],
            'gender' => ['nullable', 'digits:1'],
            'website' => ['nullable', 'string'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'profile_status' => ['nullable', 'integer', Rule::in(array_map(fn ($case) => $case->value, ProfileStatus::cases()))],
        ];
    }
}
