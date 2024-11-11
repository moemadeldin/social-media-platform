<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'email' => ['required_without_all:mobile,username', 'email', 'exists:users,email'],
            'mobile' => ['required_without_all:email,username', 'string', 'exists:users,mobile'],
            'username' => ['required_without_all:email,mobile', 'string', 'exists:users,username']
        ];
    }
}