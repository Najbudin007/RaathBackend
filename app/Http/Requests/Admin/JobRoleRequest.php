<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobRoleRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            $rules['title'] = ['required','string','max:255','unique:job_roles'];
        } else {
            $rules['title'] = ['required','string','max:255',Rule::unique('job_roles')->ignore($this->job_role)];
        }
        
        return $rules;
    }
}