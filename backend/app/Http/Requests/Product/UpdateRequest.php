<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'categories' => 'array|nullable',
            'categories.*' => 'exists:categories,id',
            'main_image' => 'exists:media,id',
            'gallery_images' => 'array|nullable',
            'gallery_images.*' => 'exists:media,id'
        ];
    }
}
