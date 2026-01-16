<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
    public function rules($password,$id = null)
    {
        return [
            'email'            => "required|email|unique:users,email," . $id,
            'password'         =>( $password != null ? 'min:6' : ''),
            'MOP'            => "required|numeric|phone_number|unique:users,MOP," . $id,
        ];
    }
}
