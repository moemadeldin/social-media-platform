<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Util\APIResponder;
class CreateUserRequest extends FormRequest
{
    use APIResponder;
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
            'username' => ['required', 'string', 'unique:users,username'],
            'email' => ['required_without:mobile', 'email:rfc,dns', 'unique:users,email'],
            'mobile' => ['required_without:email', 'string', 'unique:users,mobile'],
            'full_name' => ['required', 'string'],
            'password' => ['required', 'min:6', 'max:15', 'confirmed', 'regex:/[a-zA-Z]/'],
        ];
    }
}