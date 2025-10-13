<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
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

        $rules =  [
            'title' => ['nullable'],
            'status' => ['required','boolean'],
            'description' => ['nullable'],
            'url' => ['nullable'],
            
        ];
        if($this->getMethod() =='POST') {
            $rules += [
                'image' => ['required','mimes:jpg,jpeg,gif,png']
            ];
        }
        if($this->getMethod() =='PUT') {
            $rules += [
                'image' => ['mimes:jpg,jpeg,gif,png']
            ];
        }

        return $rules;
    }
}
