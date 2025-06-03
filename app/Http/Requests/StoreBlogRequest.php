<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // We'll handle authorization in middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'author' => 'nullable|string|max:100',
            'content' => 'required|string',
            'innovation_content' => 'nullable|string',
            'img_url' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'read_time' => 'nullable|integer|min:1|max:120',
            'is_published' => 'boolean'
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Blog title is required',
            'title.max' => 'Blog title cannot exceed 255 characters',
            'category.required' => 'Blog category is required',
            'content.required' => 'Blog content is required',
            'img_url.url' => 'Image URL must be a valid URL',
            'read_time.min' => 'Read time must be at least 1 minute',
            'read_time.max' => 'Read time cannot exceed 120 minutes'
        ];
    }
}
