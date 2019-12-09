<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'name' => Str::title($this->name),
                'description' => $this->description,
                'price' => $this->price,
                'categories' => CategoryResource::collection($this->categories),
                'main_image' => $this->getMainMediaUrl(),
                'gallery_images' => $this->getGalleryMediaUrl()
            ];
    }
}
