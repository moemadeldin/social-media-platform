<?php

namespace App\Http\Requests;

use App\Enums\MediaType;
use App\Enums\PostVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
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
            'caption' => ['nullable', 'string'],
            'visibility' => ['required', 'integer', Rule::in(array_map(fn($case) => $case->value, PostVisibility::cases()))],
            'collaborator' => ['nullable', 'string'],
            'location' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
        ];
    }
}
