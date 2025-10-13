<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetricsRequest extends FormRequest
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
            'value' => ['required','string','max:255'],
        ];

        if ($this->isMethod('POST')) {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:metrics'];
        } else {
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('metrics')->ignore($this->metric)];
        }

        return $rules;
    }
}