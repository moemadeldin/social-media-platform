<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\PostVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route('post');

        return $post && $this->user()->id === $post->user_id;
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
            'visibility' => ['nullable', 'digits:1', Rule::in(PostVisibility::cases())],
            'collaborator' => ['nullable', 'string'],
            'location' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
        ];
    }
}
