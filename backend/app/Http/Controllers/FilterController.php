<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    private $result;

    public function filter(Request $request)
    {

        $this->result = $this->filterByCategories($request->categories);
        $this->result = $this->filterByPrice($this->result, $request->min, $request->max);
        $this->result = $this->sortBy($this->result, $request->sort, $request->desc);

        return ProductResource::collection($this->result);

    }

    private function filterByCategories($categories)
    {

        if (!$categories) return Product::all();

        $filtered = collect();

        foreach (Product::all() as $product) {
            $cat_array = $product->categories;
            if (count($cat_array) == 0) continue;

            if (!array_diff($categories, $cat_array->pluck('name')->toArray())) {
                $filtered->push($product);
            }
        }

        return $filtered;
    }

    private function filterByPrice($products, $min, $max)
    {
        $filtered = $products;
        if ($min) $filtered = $filtered->where('price', '>=', $min);
        if ($max) $filtered = $filtered->where('price', '<=', $max);

        return $filtered;
    }

    private function sortBy($products, $sort, $desc)
    {
        if ($desc) return $products->sortByDesc($sort);
        return $products->sortBy($sort);
    }
}
