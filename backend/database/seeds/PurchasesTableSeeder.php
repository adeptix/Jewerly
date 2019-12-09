<?php

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Purchase::class, 10)->create();
    }
}
