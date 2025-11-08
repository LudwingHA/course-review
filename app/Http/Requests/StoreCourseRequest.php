<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isInstructor();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string|max:255',
            'content_table' => 'nullable|string',
            'youtube_urls' => 'nullable|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ];
    }

}