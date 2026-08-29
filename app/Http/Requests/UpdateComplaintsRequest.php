<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Complaints;

class UpdateComplaintsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'          => 'nullable|exists:users,id',
            'aqars_id'         => 'nullable|exists:aqar,id',
            'status'           => 'required|integer|in:' . implode(',', [
                Complaints::COMPLAINT_PENDING,
                Complaints::COMPLAINT_INPROGRESS,
                Complaints::COMPLAINT_SOLVED,
            ]),
            'message'          => 'nullable|string',
            'solution_details' => 'required|string|min:1|max:5000',
        ];
    }

    public function attributes()
    {
        return [
            'status'           => 'الحالة',
            'solution_details' => 'تفاصيل حل المشكلة',
        ];
    }

    public function messages()
    {
        return [
            'status.required'           => 'الحالة حقل إلزامي.',
            'status.in'                 => 'يجب اختيار حالة صحيحة.',
            'solution_details.required' => 'تفاصيل حل المشكلة حقل إلزامي.',
        ];
    }
}
