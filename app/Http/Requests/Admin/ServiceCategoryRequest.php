<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceCategoryRequest extends FormRequest
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
            'sub_title' => ['required'],
            'status' => ['required'],
            'description' => ['required']
        ];

        if ($this->isMethod('POST')) {
            $rules['title'] = ['required', 'string', 'max:255', 'unique:service_categories'];
            $rules['icon'] = ['nullable', 'mimes:jpg,jpeg,gif,png,svg'];
        } else {
            $rules['title'] = ['required', 'string', 'max:255', Rule::unique('service_categories')->ignore($this->service_category)];
            $rules['icon'] = ['nullable','mimes:jpg,jpeg,gif,png,svg'];
        }

        return $rules;

    }
}
