<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Optix\Media\HasMedia;

class Product extends Model
{
    use HasMedia;

    protected $fillable = [
        'name', 'description', 'price', 'buy_qty'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getMainMediaUrl()
    {
        return $this->getFirstMediaUrl('main');
    }

    public function getGalleryMediaUrl()
    {
        $url_array = [];
        foreach ($this->getMedia('gallery') as $media){
            $url_array[] = $media->getUrl();
        }
        return $url_array;
    }




}
