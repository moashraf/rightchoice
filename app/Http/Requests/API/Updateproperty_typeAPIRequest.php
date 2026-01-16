<?php

namespace App\Http\Requests\API;

use App\Models\property_type;
use InfyOm\Generator\Request\APIRequest;

class Updateproperty_typeAPIRequest extends APIRequest
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
        $rules = property_type::$rules;
        
        return $rules;
    }
}
