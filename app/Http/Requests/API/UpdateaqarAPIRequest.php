<?php

namespace App\Http\Requests\API;

use App\Models\aqar;
use InfyOm\Generator\Request\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateaqarAPIRequest extends APIRequest
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
     * في التعديل: الحقول المطلوبة تصبح sometimes بدل required
     *
     * @return array
     */
    public function rules()
    {
        $rules = aqar::$rules;

        // في التعديل: الحقول المطلوبة تصبح اختيارية (لو اتبعتت لازم تكون صح)
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('required|', 'sometimes|', $rule);
            $rules[$field] = str_replace('required', 'sometimes', $rules[$field]);
        }

        return $rules;
    }

    /**
     * رسائل الأخطاء بالعربي
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.string'            => __('validation.titleError'),
            'description.string'      => __('validation.descError'),
            'offer_type.exists'       => __('validation.offerError'),
            'category.exists'         => __('validation.categoryError'),
            'property_type.exists'    => __('validation.aqarError'),
            'user_id.exists'          => 'المستخدم غير موجود',
            'governrate_id.exists'    => __('validation.countryError'),
            'district_id.exists'      => __('validation.areaError'),
            'call_id.exists'          => __('validation.callTimeError'),
            'finishtype.exists'       => __('validation.finishError'),
            'license_type.exists'     => __('validation.licenseError'),
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
