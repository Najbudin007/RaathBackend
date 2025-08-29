<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'type' => 'required|string|in:order,membership,donation',
            'reference_type' => 'nullable|string',
            'reference_id' => 'nullable|integer',
            'amount' => 'required|numeric|min:0',
            'currency' => 'string|max:3|default:USD',
            'status' => 'string|in:pending,completed,failed,refunded|default:pending',
            'payment_method' => 'required|string',
            'payment_gateway' => 'nullable|string',
            'description' => 'nullable|string',
            'metadata' => 'nullable|array',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.exists' => 'The selected user does not exist.',
            'type.required' => 'Transaction type is required.',
            'type.in' => 'Invalid transaction type.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be at least 0.',
            'status.in' => 'Invalid transaction status.',
            'payment_method.required' => 'Payment method is required.',
        ];
    }
}
