<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    public function run()
    {
        $all_categories = [
            ['type' => 'Тип изделия', 'names' => ['Кольца', 'Серьги', 'Цепи и колье', 'Браслеты', 'Кулоны']],
            ['type' => 'Металл', 'names' => ['Золото', 'Серебро', 'Платина']],
            ['type' => 'Вставка', 'names' => ['Бриллиант', 'Изумруд', 'Рубин', 'Аметист', 'Жемчуг']],
            ['type' => 'Для кого', 'names' => ['Для мужчин', 'Для женщин']],
        ];

        $cat_array = [];

        foreach ($all_categories as $type_array) {
            $type = $type_array['type'];
            foreach ($type_array['names'] as $name) {
                $cat_array[] = Category::create([
                    'type' => $type,
                    'name' => $name,
                ]);
            }

            foreach(Product::all() as $product){
                $product->categories()->attach($cat_array[array_rand($cat_array)]->id);
            }
            $cat_array = [];
        }
    }



}


