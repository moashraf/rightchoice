<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SettingSite;

class CreateSettingSiteRequest extends FormRequest
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
    public function rules($type = 'add')
    {
        return [
            'Title'                => 'required',
            'Address'              => 'required',
            'map_link'             => 'required',
            'Mobile'               => 'required',
            'mail'                 => 'required',
            'facebook'             => 'required',
            'linkedin'             => 'required',
            'insta'                => 'required',
            'tiwiter'              => 'required',
            'youtube'              => 'required',
            'img_logo'             => ($type == 'add') ? 'required|image|mimes:jpeg,png,jpg,gif,svg' : 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_icon'             => ($type == 'add') ? 'required|image|mimes:jpeg,png,jpg,gif,svg' : 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
