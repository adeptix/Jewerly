<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        CartItem::create([
           'product_id' => 1,
           'user_id' => $this->user->id,
           'qty' => 2
        ]);

    }


    public function test_add_to_cart()
    {
        $data = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'qty' => 5,
        ];

        $response = $this->actingAs($this->user, 'api')
            ->postJson(
                route('cart.add'),
                $data
            );

        $response
            ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'cart_item'
            ]);

    }

    public function test_add_without_qty()
    {
        $data = [
            'product_id' => Product::inRandomOrder()->first()->id,
        ];

        $response = $this->actingAs($this->user, 'api')
            ->postJson(
                route('cart.add'),
                $data
            );

        $response
            ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'cart_item'
            ]);

    }

    public function test_add_to_cart_same_item()
    {
        $data = [
            'product_id' => 1,
            'qty' => 2,
        ];

        $response = $this->actingAs($this->user, 'api')
            ->postJson(
                route('cart.add'),
                $data
            );

        $response
            ->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'cart_item'
            ]);

    }

    public function test_change_qty(){
        $data = [
            'product_id' => 1,
        ];

        $response = $this->actingAs($this->user, 'api')
            ->putJson(
                route('cart.change-qty', 1),
                $data
            );

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'cart_item'
            ]);
    }

    public function test_delete_item_cart(){

        $response = $this->actingAs($this->user, 'api')
            ->deleteJson(
                route('cart.delete', 1)
            );

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'cart'
            ]);

    }

    public function test_clear_cart(){
        $response = $this->actingAs($this->user, 'api')
            ->deleteJson(
                route('cart.clear')
            );

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'message', 'cart'
            ]);

    }





}
