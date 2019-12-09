<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilteringTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    public function testSuccess()
    {
        $data = [
            'categories' => ['Кольца'],
            'max' => 100,
            'sort' => 'name'
        ];
        $response = $this->getJson(
            route('filter', $data)
        );

        $response->dump()
            ->assertStatus(200);
    }
}
