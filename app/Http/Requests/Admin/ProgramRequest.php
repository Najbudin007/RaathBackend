<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            'branch_id' => 'required|exists:branches,id',
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'day_of_week' => 'nullable|integer|between:0,6',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'is_recurring' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ];
    }
}
