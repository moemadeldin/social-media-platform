<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateStoryRequest extends FormRequest
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
            'content' => $this->getValidationRule('content')
        ];
    }

    public function getValidationRule($key)
    {
        if(request()->hasFile($key)){
            return ['nullable', 'mimes:png,jpg,mp4'];
        }
        return ['nullable', 'string'];
    }
}
