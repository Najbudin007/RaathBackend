<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioCategoryRequest extends FormRequest
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
            'status' => ['required']
        ];

        if ($this->isMethod('POST')) {
            $rules['title'] = ['required', 'string', 'max:255', 'unique:portfolio_categories'];
        } else {
            $rules['title'] = ['required', 'string', 'max:255', Rule::unique('portfolio_categories')->ignore($this->portfolio_category)];
        }

        

        return $rules;
    }
}