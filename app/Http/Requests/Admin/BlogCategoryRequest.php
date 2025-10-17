<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
            'status' => ['required', 'in:0,1'],
        ];

        if ($this->isMethod('POST')) {
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('blog_categories')];
        } else if ($this->isMethod('PUT')) {
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('blog_categories')->ignore($this->blog_category)];
        }

        return $rules;
    }
}
