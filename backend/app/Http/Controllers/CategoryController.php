<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }


    public function store(StoreRequest $request)
    {
        $category = Category::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Категория создана успешно',
            'category' => new CategoryResource($category)
        ], 201);
    }


    public function show($category)
    {
        return new CategoryResource($category);
    }


    public function update(UpdateRequest $request, Category $category)
    {
        $category->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Категория обновлена',
            'category' => new CategoryResource($category)
        ], 204);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        //need handle

        return response()->json([
            'message' => 'Категория удалена',
            'category' => new CategoryResource($category)
        ], 204);
    }
}
