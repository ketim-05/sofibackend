<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Since we're using middleware for auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image_url' => 'nullable|string',
            'is_active' => 'nullable|boolean|in:true,false,1,0,"true","false"',
            'is_featured' => 'nullable|boolean|in:true,false,1,0,"true","false"',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB = 10240KB
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'message.required' => 'The testimonial message is required.',
            'rating.required' => 'Please provide a rating.',
            'rating.min' => 'Rating must be at least 1.',
            'rating.max' => 'Rating cannot exceed 5.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size cannot exceed 10MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert string booleans to actual booleans
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        if ($this->has('is_featured')) {
            $this->merge([
                'is_featured' => filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
    }
} 