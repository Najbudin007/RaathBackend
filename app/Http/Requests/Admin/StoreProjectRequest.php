<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:projects,title'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'vision' => ['nullable', 'string'],
            'technical_specs' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'design_docs.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:5120'],
            'target_amount' => ['required', 'numeric', 'min:0'],
            'collected_amount' => ['nullable', 'numeric', 'min:0', 'lte:target_amount'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:planning,active,on-hold,completed,cancelled'],
            'is_featured' => ['boolean'],
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
            'target_amount' => 'target amount',
            'collected_amount' => 'collected amount',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'design_docs.*' => 'design documents',
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
            'title.unique' => 'This project title is already taken.',
            'slug.unique' => 'This slug is already taken.',
            'description.required' => 'Project description is required.',
            'target_amount.required' => 'Target amount is required.',
            'target_amount.min' => 'Target amount must be at least 0.',
            'collected_amount.lte' => 'Collected amount cannot exceed target amount.',
            'end_date.after' => 'End date must be after start date.',
            'image.max' => 'Main image must not be larger than 2MB.',
            'image.mimes' => 'Main image must be a file of type: jpeg, png, jpg, gif, webp.',
            'images.*.max' => 'Gallery images must not be larger than 2MB each.',
            'images.*.mimes' => 'Gallery images must be files of type: jpeg, png, jpg, gif, webp.',
            'design_docs.*.max' => 'Documents must not be larger than 5MB each.',
            'design_docs.*.mimes' => 'Documents must be files of type: pdf, doc, docx, xls, xlsx, ppt, pptx.',
        ];
    }
}

