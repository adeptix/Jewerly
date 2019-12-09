<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {

    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'product_id' => Product::inRandomOrder()->first()->id,
        'qty' => mt_rand(1, 10),
        'price' => mt_rand(0, 10000) / 100,
        'additional_info' => $this->faker->text(100)
    ];
});
