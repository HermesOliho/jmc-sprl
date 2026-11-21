<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('access-admin');
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'icon' => ['required', 'string', 'max:50', 'regex:/^[a-z0-9-]+$/'],
            'deliverables' => ['nullable', 'array', 'max:20'],
            'deliverables.*' => ['required', 'string', 'max:255'],
            'benefits' => ['nullable', 'array', 'max:20'],
            'benefits.*' => ['required', 'string', 'max:255'],
            'is_featured' => ['sometimes', 'boolean'],
            'home_sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_cover' => ['sometimes', 'boolean'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image_position' => ['nullable', 'string', Rule::in(['center', 'top', 'bottom', 'left', 'right'])],
        ];
    }
}
