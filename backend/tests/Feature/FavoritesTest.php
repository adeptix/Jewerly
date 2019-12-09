<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{

    public function test_success_add()
    {
        $data = ['product_id' => Product::inRandomOrder()->first()->id];

        $response = $this->actingAs($this->user, 'api')
            ->postJson(route('favorites.add'), $data);

        $response->dump()
            ->assertStatus(201)
            ->assertJsonStructure(['message']);

        $this->assertNotEmpty($this->user->favorites);
    }

    public function test_success_delete(){
        DB::table('product_user')->insert(
            ['product_id' => 1, 'user_id' => $this->user->id]
        );

        $response = $this->actingAs($this->user, 'api')
            ->deleteJson(route('favorites.delete', 1));

        $response->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }
}
