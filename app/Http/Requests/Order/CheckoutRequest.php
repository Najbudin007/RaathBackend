<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email',
            'notes' => 'nullable|string',
            'payment_method' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'shipping_address.required' => 'Shipping address is required.',
            'billing_address.required' => 'Billing address is required.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'payment_method.required' => 'Payment method is required.',
        ];
    }
}
