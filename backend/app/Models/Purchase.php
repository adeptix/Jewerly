<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $fillable = [
        'user_id', 'product_id', 'price', 'qty', 'additional_info'
    ];

    public function product(){
        return $this->hasOne(Product::class);
    }

    public function customer(){
        return $this->belongsTo(User::class);
    }

}
