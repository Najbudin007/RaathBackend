<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'description' => ['required', 'max:50000'],
            'status' => ['required', 'boolean'],
            'email' => ['nullable','email', 'max:255'],
            'image' => ['nullable', 'mimes:jpg,jpeg,gif,png', 'max:10000'],
            'facebook' => ['nullable','url','max:255'],
            'linkedin' => ['nullable','url','max:255'],
            'website' => ['nullable','url','max:255'],
            'type' => ['nullable', Rule::in(['gbc', 'executive'])],
            'achievements' => ['nullable', 'array'],
            'achievements.*' => ['string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }
}
