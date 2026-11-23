<?php

namespace App\Http\Requests\Admin;

use App\Models\Album;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReorderAlbumPhotosRequest extends FormRequest
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
        $album = $this->route('album');

        return [
            'photo_ids' => ['required', 'array', 'min:1'],
            'photo_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('album_photos', 'id')->where(
                    'album_id',
                    $album instanceof Album ? $album->id : null,
                ),
            ],
        ];
    }
}
