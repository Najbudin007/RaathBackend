<?php

namespace App\Http\Requests\BudgetBreakdown;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetBreakdownRequest extends FormRequest
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
            'project_id' => 'required|exists:projects,id',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }
}
