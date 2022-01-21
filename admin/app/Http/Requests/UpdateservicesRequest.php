<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\services;

class UpdateservicesRequest extends FormRequest
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
    public function rules($type = 'show')
    {
        return [
            'Service'           => 'required',
            'image'       => ($type == 'add') ? 'required|image|mimes:jpeg,jpg,png,gif' : 'image|mimes:jpeg,jpg,png,gif',

        ];
    }
}
