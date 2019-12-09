<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;


class DestroyTest extends TestCase
{
    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = factory(Product::class)->create();
    }

    public function testSuccess()
    {
        $response = $this
            ->actingAs($this->admin, 'api')
            ->deleteJson(
                route('products.destroy', $this->product)
            );


        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'product'
            ]);
    }


    public function testNoAuth()
    {
        $response = $this
            ->deleteJson(
                route('products.destroy', $this->product)
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
            ->deleteJson(
                route('products.destroy', $this->product)
            );


        $response
            ->dump()
            ->assertStatus(403)
            ->assertJsonStructure([
                'message'
            ]);
    }

}
