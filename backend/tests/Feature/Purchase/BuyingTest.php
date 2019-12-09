<?php

namespace Tests\Feature\Purchase;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuyingTest extends TestCase
{

    private $data1;
    private $data2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data1 = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'qty' => 1,
            'price' => 9.54,
            'additional_info' => $this->faker->text(100)
        ];
        $this->data2 = [
            'product_id' => Product::inRandomOrder()->first()->id,
            'qty' => 13,
            'price' => 19.1,
            'additional_info' => $this->faker->text(100)
        ];
    }

    public function testSuccessBuying()
    {

        $response = $this
            ->actingAs($this->user, 'api')
            ->postJson(
                route('purchases.auth_buy'),
                $this->data1
            );


        $response->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'purchase'
            ]);
    }

    public function test_guest_buying()
    {

        $response = $this->postJson(
            route('purchases.guest_buy'),
            $this->data1
        );

        $response->dump()
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'purchase'
            ]);
    }

    public function test_history_after_buying()
    {
        $this->actingAs($this->user, 'api')
            ->postJson(
                route('purchases.auth_buy'),
                $this->data1
            );

        $this->actingAs($this->user, 'api')
            ->postJson(
                route('purchases.auth_buy'),
                $this->data2
            );


        $response = $this
            ->actingAs($this->user, 'api')
            ->getJson(
                route('user.history')
            );

        $response->dump()
            ->assertStatus(200)
            ->assertJsonStructure([
                'history'
            ]);


    }


}
