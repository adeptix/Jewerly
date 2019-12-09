<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id|integer',
            'price' => 'required|numeric|min:0',
            'qty' => 'numeric|min:1',
            'additional_info' => 'string'
        ];
    }
}
