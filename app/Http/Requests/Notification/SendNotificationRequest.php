<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|in:order,membership,donation,system',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'nullable|array',
            'channel' => 'required|string|in:email,sms,push,in_app',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'type.required' => 'Notification type is required.',
            'type.in' => 'Invalid notification type.',
            'title.required' => 'Notification title is required.',
            'message.required' => 'Notification message is required.',
            'channel.required' => 'Notification channel is required.',
            'channel.in' => 'Invalid notification channel.',
        ];
    }
}
