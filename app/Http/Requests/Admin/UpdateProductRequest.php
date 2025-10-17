<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateProductRequest extends FormRequest
{
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
        $productId = $this->route('product')->id;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert empty strings to null for file fields to prevent validation issues
        if ($this->has('image') && $this->image === '') {
            $this->merge(['image' => null]);
        }
        
        if ($this->has('images')) {
            $images = collect($this->images)->filter(function ($image) {
                return $image !== '';
            })->values()->toArray();
            $this->merge(['images' => $images]);
        }
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
            'name.unique' => 'This product name is already taken.',
            'slug.unique' => 'This slug is already taken.',
            'price.required' => 'Product price is required.',
            'price.min' => 'Price must be at least 0.',
            'sale_price.lt' => 'Sale price must be less than regular price.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
            'image.max' => 'Main image must not be larger than 5MB.',
            'image.mimes' => 'Main image must be a file of type: jpeg, png, jpg, gif, webp, avif.',
            'images.*.max' => 'Gallery images must not be larger than 5MB each.',
            'images.*.mimes' => 'Gallery images must be files of type: jpeg, png, jpg, gif, webp, avif.',
        ];
    }
}

