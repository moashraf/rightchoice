<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'  => 'required|string|in:' . implode(',', PaymentStatusEnum::all()),
            'message' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حالة الدفع مطلوبة.',
            'status.in'       => 'حالة الدفع غير صالحة.',
        ];
    }
}
