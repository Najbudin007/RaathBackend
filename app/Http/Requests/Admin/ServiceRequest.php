<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'title' => ['required'],
            'sub_title' => ['required'],
            'category_id' => ['required','integer'],
            'status' => ['required'],
            'description' => ['required']
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'icon' => ['required', 'mimes:jpg,jpeg,gif,png']
            ];
        }

        else if ($this->getMethod() == 'PUT') {
            $rules += [
                'icon' => ['nullable','mimes:jpg,jpeg,gif,png']
            ];
        }

        return $rules;
    }
}