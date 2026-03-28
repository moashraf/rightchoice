<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRefundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refund_amount' => 'required|numeric|min:0.01',
            'refund_reason' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'refund_amount.required' => 'مبلغ الاسترداد مطلوب.',
            'refund_amount.min'      => 'مبلغ الاسترداد يجب أن يكون أكبر من صفر.',
            'refund_reason.required' => 'سبب الاسترداد مطلوب.',
        ];
    }
}
