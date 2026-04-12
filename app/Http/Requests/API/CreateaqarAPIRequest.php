<?php

namespace App\Http\Requests\API;

use App\Models\aqar;
use InfyOm\Generator\Request\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateaqarAPIRequest extends APIRequest
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
        return aqar::$rules;
    }

    /**
     * رسائل الأخطاء بالعربي
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'          => __('validation.titleError'),
            'description.required'    => __('validation.descError'),
            'offer_type.required'     => __('validation.offerError'),
            'offer_type.exists'       => __('validation.offerError'),
            'category.required'       => __('validation.categoryError'),
            'category.exists'         => __('validation.categoryError'),
            'property_type.required'  => __('validation.aqarError'),
            'property_type.exists'    => __('validation.aqarError'),
            'user_id.required'        => 'من فضلك حدد المستخدم',
            'user_id.exists'          => 'المستخدم غير موجود',
            'governrate_id.required'  => __('validation.countryError'),
            'governrate_id.exists'    => __('validation.countryError'),
            'district_id.required'    => __('validation.areaError'),
            'district_id.exists'      => __('validation.areaError'),
            'call_id.required'        => __('validation.callTimeError'),
            'call_id.exists'          => __('validation.callTimeError'),
            'finishtype.exists'       => __('validation.finishError'),
            'license_type.exists'     => __('validation.licenseError'),
            'total_area.required'     => __('validation.totalAreaError'),
            'total_area.numeric'      => __('validation.totalAreaError'),
            'rooms.integer'           => __('validation.roomsError'),
            'baths.integer'           => __('validation.bathError'),
            'floor.integer'           => __('validation.floorError'),
            'number_of_floors.integer'=> __('validation.floorsNumError'),
            'total_price.numeric'     => __('validation.priceError'),
            'downpayment.numeric'     => __('validation.downPaymentError'),
            'monthly_rent.numeric'    => __('validation.rentError'),
            'reciving.numeric'        => __('validation.recivingError'),
            'rec_time.string'         => __('validation.recivingTimeError'),
        ];
    }

    /**
     * لو الـ validation فشل → يرجع JSON دايماً (مش redirect)
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
