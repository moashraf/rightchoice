<?php

namespace App\Http\Requests;

use App\Enums\SmsSendTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation for the SMS send form.
 *
 * Ensures message template is provided, send type is valid,
 * and user IDs are supplied when targeting selected users.
 */
class SendSmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permission check handled by middleware
    }

    public function rules(): array
    {
        $rules = [
            'message_template' => ['required', 'string', 'min:5', 'max:640'],
            'send_type'        => ['required', 'string', 'in:all_users,selected_users'],
        ];

        // When sending to selected users, user_ids is required
        if ($this->input('send_type') === SmsSendTypeEnum::SELECTED_USERS) {
            $rules['user_ids']   = ['required', 'array', 'min:1'];
            $rules['user_ids.*'] = ['required', 'integer', 'exists:users,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'message_template.required' => 'يجب إدخال نص الرسالة',
            'message_template.min'      => 'يجب أن تحتوي الرسالة على 5 حروف على الأقل',
            'message_template.max'      => 'يجب ألا تتجاوز الرسالة 640 حرف',
            'send_type.required'        => 'يجب اختيار نوع الإرسال',
            'send_type.in'              => 'نوع الإرسال غير صالح',
            'user_ids.required'         => 'يجب اختيار مستخدم واحد على الأقل',
            'user_ids.min'              => 'يجب اختيار مستخدم واحد على الأقل',
            'user_ids.*.exists'         => 'أحد المستخدمين المحددين غير موجود',
        ];
    }

    /**
     * Remove duplicate user IDs before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('user_ids') && is_array($this->user_ids)) {
            $this->merge([
                'user_ids' => array_values(array_unique($this->user_ids)),
            ]);
        }
    }
}
