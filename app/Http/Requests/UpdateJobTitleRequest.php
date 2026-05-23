<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobTitleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Job_title' => 'required|string|max:191',
            'Job_title_en' => 'nullable|string|max:191',
        ];
    }
}
