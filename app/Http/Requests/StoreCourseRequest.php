<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isInstructor();
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'], // 👈 Asegura que la categoría existe
            'tags' => ['nullable', 'string'],
            'content_table' => ['nullable', 'string'],
            'youtube_urls' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ];
    }

}