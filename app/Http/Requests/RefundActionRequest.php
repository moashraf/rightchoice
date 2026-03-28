<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_note'              => 'nullable|string|max:1000',
            'refund_reference_number' => 'nullable|string|max:255',
        ];
    }
}
