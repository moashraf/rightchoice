<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\property_type;

class Createproperty_typeRequest extends FormRequest
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
            'property_type'     => 'required',
            'cat_id'            => "required|numeric|min:1|if_find:App\aqar_category,$request->cat_id",
        ];
    }
}
