<?php

namespace Tests;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;
    protected $admin;
    protected $products;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();



        $this->artisan('migrate');
        $this->seed('ProductsTableSeeder');
        $this->seed('CategoriesTableSeeder');


        $this->faker = Faker::create();
        $this->user = factory(User::class)->create();
        $this->admin = factory(User::class)->create([
           'isAdmin' => true
        ]);
        $this->products = Product::inRandomOrder()->take(5)->get();

    }
}
