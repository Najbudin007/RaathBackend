<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert unchecked checkboxes to false
        if (!$this->has('is_active')) {
            $this->merge(['is_active' => false]);
        }
        if (!$this->has('is_featured')) {
            $this->merge(['is_featured' => false]);
        }
    }


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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'category' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:image,video'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'metadata' => ['nullable', 'array'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'image_url' => 'image',
            'alt_text' => 'alt text',
            'sort_order' => 'sort order',
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
            'title.required' => 'Gallery title is required.',
            'image_url.required' => 'Please upload an image.',
            'image_url.max' => 'Image must not be larger than 5MB.',
            'image_url.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, webp.',
            'category.required' => 'Category is required.',
            'type.required' => 'Type is required.',
        ];
    }
}

