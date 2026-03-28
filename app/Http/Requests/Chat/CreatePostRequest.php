<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:5000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'محتوى المنشور مطلوب',
            'content.max' => 'محتوى المنشور طويل جداً',
            'images.max' => 'لا يمكن رفع أكثر من 5 صور',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.mimes' => 'صيغة الصورة غير مدعومة',
            'images.*.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت',
        ];
    }
}
