<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => 'required|string|max:5000',
            'receiver_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'الرسالة مطلوبة',
            'body.max' => 'الرسالة طويلة جداً',
            'receiver_id.required' => 'المستلم مطلوب',
            'receiver_id.exists' => 'المستلم غير موجود',
        ];
    }
}
