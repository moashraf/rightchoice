<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Notification;
use App\Http\Requests;
class UpdateNotificationRequest extends FormRequest
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
            'type'         => 'required|integer|between:0,1',
            'user_id'      => (Request()->type == 0) ?'required|integer|min:1' : '',
            'title'        => 'required',
            'message'      => 'required',
        ];
    }
}
