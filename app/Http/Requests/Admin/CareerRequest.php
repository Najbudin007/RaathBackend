<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CareerRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'string', 'max:255'],
            'position_id' => ['required', 'integer'],
            'description' => ['required', 'max:25000'],
            'status' => ['required', 'boolean'],
            'expired_date' => ['required', 'date'],
            'image' => ['nullable', 'mimes:jpg,jpeg,gif,png', 'max:10000']
        ];

        return $rules;
    }
}
