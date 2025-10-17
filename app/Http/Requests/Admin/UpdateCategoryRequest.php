<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category')->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($categoryId)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
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
            'is_active' => 'status',
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
            'name.unique' => 'This category name is already taken.',
            'slug.unique' => 'This slug is already taken.',
            'image.max' => 'The image must not be larger than 2MB.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
        ];
    }
}

