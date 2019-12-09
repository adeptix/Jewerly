<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price
        ];
    }
}
