<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'logo' => ['nullable','mimes:png,jpg,jpeg,webp', 'max:5000'],
            'favicon' => ['nullable','mimes:png,jpg,jpeg,webp', 'max:5000'],
            'meta_title' => ['nullable', 'string', 'max:100'],
            'meta_keyword' => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'item_perpage' => ['nullable', 'integer'],
            'description_limit' => ['nullable', 'integer'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'google_analytics' => ['nullable', 'string', 'max:255'],
            'thumb_height' => ['nullable', 'integer'],
            'thumb_width' => ['nullable', 'integer'],
            'image_height' => ['nullable', 'integer'],
            'image_width' => ['nullable', 'integer'],
            'protocol' => ['nullable','string', 'max:100'],
            'parameter' => ['nullable', 'string', 'max:100'],
            'host_name' => ['nullable', 'string', 'max:100'],
            'username' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'max:100'],
            'smtp_port' => ['nullable', 'string', 'max:100'],
            'encryption' => ['nullable', 'string', 'max:100'],
            'social.title' => ['nullable', 'array'],
            'social.icon' => ['nullable', 'array'],
            'social.url' => ['nullable', 'array'],
            'social.title.*' => ['required', 'string', 'max:100'],
            'social.icon.*' => ['required', 'string', 'max:100'],
            'social.url.*' => ['required', 'url', 'max:255'],
        ];
    }
}
