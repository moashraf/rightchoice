<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'reported_id' => 'required|integer|exists:users,id',
            'reported_type' => 'required|string|in:user,message,post,comment',
            'reported_content_id' => 'nullable|string',
            'reason' => 'required|string|in:spam,harassment,inappropriate,fake,other',
            'details' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'reported_id.required' => 'المستخدم المبلغ عنه مطلوب',
            'reported_id.exists' => 'المستخدم غير موجود',
            'reported_type.required' => 'نوع البلاغ مطلوب',
            'reported_type.in' => 'نوع البلاغ غير صالح',
            'reason.required' => 'سبب البلاغ مطلوب',
            'reason.in' => 'سبب البلاغ غير صالح',
            'details.max' => 'التفاصيل طويلة جداً',
        ];
    }
}
