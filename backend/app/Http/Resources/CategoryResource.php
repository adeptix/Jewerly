<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => Str::title($this->type),
            'name' => Str::title($this->name),
            'count' => $this->products()->count()
        ];
    }
}
