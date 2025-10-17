<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Debug: Log incoming data before validation
        \Log::info('StoreProductRequest prepareForValidation:', [
            'all_data' => $this->all(),
            'files' => $this->allFiles(),
            'method' => $this->method(),
            'headers' => $this->headers->all()
        ]);

        // Convert empty strings to null for numeric fields
        if ($this->has('price') && $this->price === '') {
            $this->merge(['price' => null]);
        }
        
        if ($this->has('sale_price') && $this->sale_price === '') {
            $this->merge(['sale_price' => null]);
        }
        
        if ($this->has('stock_quantity') && $this->stock_quantity === '') {
            $this->merge(['stock_quantity' => null]);
        }
        
        if ($this->has('sort_order') && $this->sort_order === '') {
            $this->merge(['sort_order' => null]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => [
                'nullable', 
                'numeric', 
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value !== null && $this->price !== null && $value >= $this->price) {
                        $fail('The sale price must be less than the regular price.');
                    }
                },
            ],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
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
            'category_id' => 'category',
            'sale_price' => 'sale price',
            'stock_quantity' => 'stock quantity',
            'sort_order' => 'sort order',
            'images.*' => 'gallery images',
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
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Product name is required.',
            'name.unique' => 'This product name is already taken.',
            'slug.unique' => 'This slug is already taken.',
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least 0.',
            'sale_price.numeric' => 'Sale price must be a valid number.',
            'sale_price.min' => 'Sale price must be at least 0.',
            'sale_price.lt' => 'Sale price must be less than regular price.',
            'stock_quantity.integer' => 'Stock quantity must be a whole number.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
            'sort_order.integer' => 'Sort order must be a whole number.',
            'sort_order.min' => 'Sort order cannot be negative.',
            'image.image' => 'Main image must be a valid image file.',
            'image.max' => 'Main image must not be larger than 5MB.',
            'images.*.image' => 'Gallery images must be valid image files.',
            'images.*.max' => 'Gallery images must not be larger than 5MB each.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Debug: Log validation failures
        \Log::error('StoreProductRequest validation failed:', [
            'errors' => $validator->errors()->toArray(),
            'input_data' => $this->all(),
            'files' => $this->allFiles()
        ]);

        parent::failedValidation($validator);
    }
}

