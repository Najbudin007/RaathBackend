<?php

namespace App\Http\Requests\Yatra;

use Illuminate\Foundation\Http\FormRequest;

class StoreYatraRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city' => 'required|string|max:255',
            'month' => 'nullable|string|max:255',
            'collaborating_center' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'string|in:upcoming,ongoing,completed,cancelled|default:upcoming',
            'image' => 'nullable|string',
            'details' => 'nullable|array',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Yatra title is required.',
            'city.required' => 'City is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'status.in' => 'Invalid status. Must be upcoming, ongoing, completed, or cancelled.',
        ];
    }
}
