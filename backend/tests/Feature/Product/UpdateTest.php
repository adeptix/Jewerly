<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;


class UpdateTest extends TestCase
{
    private $product;
    private $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = factory(Product::class)->create();
        $this->data = [
            'name' => 'New product name'
        ];
    }

    public function testSuccess()
    {
        $response = $this
            ->actingAs($this->admin, 'api')
            ->putJson(
                route('products.update', $this->product),
                $this->data
            );

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'product'
            ]);
    }

    public function test_update_categories()
    {

        $response = $this
            ->actingAs($this->admin, 'api')
            ->putJson(
                route('products.update', $this->product),
                ['categories' => [1, 3]]
            );

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'product'
            ]);
    }

    public function test_update_invalid_categories()
    {

        $response = $this
            ->actingAs($this->admin, 'api')
            ->putJson(
                route('products.update', $this->product),
                ['categories' => [0, 76, 3]]
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
        $data = [
            'name' => false
        ];

        $response = $this
            ->actingAs($this->admin, 'api')
            ->putJson(
                route('products.update', $this->product),
                $data
            );

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);
    }

    public function testNoAuth()
    {
        $response = $this
            ->putJson(
                route('products.update', $this->product),
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
            ->putJson(
                route('products.update', $this->product),
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
