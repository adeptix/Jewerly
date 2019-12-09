<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'name' => Str::title($this->name),
                'email' => $this->email,
            ];
    }
}
