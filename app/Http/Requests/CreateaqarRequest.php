<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\aqar;

class CreateaqarRequest extends FormRequest
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
            'category'            => 'required|integer|min:1',
            'property_type'       => 'required|integer|min:1',
            'governrate_id'       => 'required|integer|min:1',
            'district_id'         => 'required|integer|min:1',
            'user_id'             => 'required|integer|min:1',
            'call_id'             => 'required|integer',
            'title'               => 'required',
            'description'         => 'required',
            'offer_type'          => 'required|integer',
            'total_price'         => 'required|integer|min:0',
            'monthly_rent'        => (Request()->offer_type == 3 || Request()->offer_type == 4) ? 'required|integer|min:0' : '',
        ];
    }
}
