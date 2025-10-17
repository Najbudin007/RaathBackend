<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'designation' => ['required','string','max:255'],
            'status' => ['required','in:0,1'],
            'description' => ['nullable','string','max:500'],
            'rating' => ['required','numeric','min:1','max:5'],
            'icon' => ['nullable', 'mimes:jpg,jpeg,gif,png'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,gif,png'],
            'url' => ['required','url','max:255'],
        ];

        return $rules;
    }
}