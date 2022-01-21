<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\blog;

class CreateblogRequest extends FormRequest
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
            'seo_title'           => 'required',
            'meta_description'    => 'required',
            'title'               => 'required',
            'description'         => 'required',
            'slug'                => 'required',
            'status'              => 'required|integer|between:0,2',
            'canonical'           => 'required',
            'sort_num'            => 'required|integer|min:1',
            'number_of_visits'    => 'required|integer|min:0',
            'img1'                => ($type == 'add') ? 'required|image|mimes:jpeg,png,jpg,gif,svg' : 'image|mimes:jpeg,png,jpg,gif,svg',
            'img2'                => ($type == 'add') ? 'required|image|mimes:jpeg,png,jpg,gif,svg' : 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
