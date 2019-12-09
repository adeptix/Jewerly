<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    private $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => mt_rand(100, 1000000000) / 100
        ];
    }

    public function testSuccess()
    {

        $response = $this
            ->actingAs($this->admin, 'api')
            ->postJson(
                route('products.store'),
                $this->data
            );

        $response
            ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'product'
            ]);
    }

    public function test_store_with_categories(){

        $response = $this
            ->actingAs($this->admin, 'api')
            ->postJson(
                route('products.store'),
                $this->data + ['categories' => [1, 2, 3]]
            );

        $response
            ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'product'
            ]);
    }

    public function test_store_with_invalid_categories(){

        $response = $this
            ->actingAs($this->admin, 'api')
            ->postJson(
                route('products.store'),
                $this->data + ['categories' => [0, 76, 3]]
            );

        $response
            ->dump()
            ->assertStatus(422)
            ->assertJsonStructure([
                'message'
            ]);
    }



    public function testInvalidData()
    {
        $this->data['name'] = false;

        $response = $this
            ->actingAs($this->admin, 'api')
            ->postJson(
                route('products.store'),
                $this->data
            );

        $response
            ->dump()
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);
    }

    public function testNoAuth()
    {

        $response = $this
            ->postJson(
                route('products.store'),
                $this->data
            );

        $response
            ->dump()
            ->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    public function testNoAdminStatus()
    {

        $response = $this
            ->actingAs($this->user, 'api')
            ->postJson(
                route('products.store'),
                $this->data
            );

        $response
            ->dump()
            ->assertStatus(403)
            ->assertJsonStructure([
                'message'
            ]);
    }




}
