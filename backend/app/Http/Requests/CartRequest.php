<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id|integer',
            'qty' => 'integer|min:1'
        ];
    }
}
