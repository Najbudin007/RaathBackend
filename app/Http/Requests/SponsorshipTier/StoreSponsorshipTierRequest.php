<?php

namespace App\Http\Requests\SponsorshipTier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorshipTierRequest extends FormRequest
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
        return [
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'inscription_type' => 'required|in:name,logo,both',
            'gifts' => 'nullable|array',
            'gifts.*' => 'string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }
}
