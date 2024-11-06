<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => ['required_without_all:mobile,email', 'string', 'exists:users,username'],
            'mobile' => ['required_without_all:username,email', 'string', 'exists:users,mobile'],
            'email' => ['required_without_all:mobile,username', 'email', 'exists:users,email'],
            'password' => ['required', 'min:6', 'max:15'],
        ];
    }
}
