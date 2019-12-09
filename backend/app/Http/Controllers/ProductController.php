<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\CartService;
use App\Services\FileService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->middleware('user.admin_status')->except(['show', 'index', 'bestsellers']);
        $this->fileService = $fileService;
    }


    public function bestsellers(Request $request)
    {
        return ProductResource::collection(Product::orderBy('buy_qty', 'desc')->take($request->num ?: 5)->get());
    }

    public function nova(Request $request)
    {
        return ProductResource::collection(Product::orderBy('created_at', 'desc')->take($request->num ?: 5)->get());
    }

    public function search(Request $request)
    {
        $result = Product::where('name', 'like', $request->q)->get();
        if (count($result) == 0) {
            return response()->json([
                'message' => 'Ничего не найдено'
            ]);
        }
        return response()->json([
            'result' => ProductResource::collection($result)
        ]);
    }

    public function mightAlsoLike($product_id)
    {
        $mightAlsoLike = Product::where('id', '!=', $product_id)->take(5)->get();

        return response()->json([
            'also' => ProductResource::collection($mightAlsoLike)
        ]);
    }

    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        if ($request->main_image) {
            $this->fileService->attachFiles($request->main_image, $product, 'main');
        }

        if ($request->gallery_images) {
            $this->fileService->attachFiles($request->gallery_images, $product, 'gallery');
        }

        return response()->json([
            'message' => 'Товар добавлен успешно',
            'product' => new ProductResource($product)
        ], 201);
    }


    public function show($product)
    {
        return response()->json([
            'product' => new ProductResource($product),
        ]);
    }


    public function update(UpdateRequest $request, Product $product)
    {
        $product->update(
            $request->validated()
        );

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        if ($request->main_image) {
            $this->fileService->attachFiles($request->main_image, $product, 'main');
        }

        if ($request->gallery_images) {
            $this->fileService->attachFiles($request->gallery_images, $product, 'gallery');
        }

        return response()->json([
            'message' => 'Информация о товаре обновлена',
            'product' => new ProductResource($product)
        ], 200);
    }


    public function destroy(Product $product)
    {
        $product->delete();
        //need handle

        return response()->json([
            'message' => 'Товар удалён',
            'product' => new ProductResource($product)
        ], 200);
    }


}
