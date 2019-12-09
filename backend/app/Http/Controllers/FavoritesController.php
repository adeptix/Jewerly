<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        ProductResource::collection(auth()->user()->favorites);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        auth()->user()->favorites()->attach($validated['product_id']);

        return response()->json([
            'message' => 'Успешно добавлено в избранное'
        ], 201);
    }

    public function delete($product_id)
    {

        auth()->user()->favorites()->detach($product_id);

        return response()->json([
            'message' => 'Успешно убрано из избранного'
        ]);
    }


}
