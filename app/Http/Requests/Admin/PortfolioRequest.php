<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioRequest extends FormRequest
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
            'title' => ['required','max:255','string'],
            // 'slug' => ['required','max:255','string'],
            'category_id' => ['required','integer'],
            'description' => ['required','string'],
            'status' => ['required','in:0,1'],
            'case_study' => ['nullable','string'],
            'feature_image' => ['nullable', 'mimes:jpg,jpeg,gif,png','max:10000']

        ];


        if ($this->getMethod() == 'POST') {
            $rules += [
                'title' => ['required', 'string', 'max:255', 'unique:portfolios'],
            ];
        }

        else if ($this->getMethod() == 'PUT') {
            $rules += [
                'title' => ['required', 'string', 'max:255', Rule::unique('portfolios')->ignore($this->portfolio)]
            ];
        }

        return $rules;
    }
}
