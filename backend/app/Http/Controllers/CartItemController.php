<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{


    public function index()
    {
        return [
            'cart' => CartResource::collection(auth()->user()->cart)
        ];

    }

    public function add(CartRequest $request)
    {
        $user = auth()->user();

        $alreadyExist = $user->cart()->where('product_id', $request->product_id)->first();
        $qty = $request->qty ?: 1;

        $price = Product::find($request->product_id)->price;


        if ($alreadyExist) {

            $alreadyExist->increment('qty', $qty);
            $alreadyExist->increment('price', $price * $qty);

            return response()->json([
                'message' => 'добавлено в корзину повторно',
                'cart_item' => $alreadyExist
            ], 201);
        }

        $cart_item = CartItem::create(
            $request->validated() + [
                'user_id' => $user->id,
                'price' => $price * $qty
            ]
        );


        return response()->json([
            'message' => 'добавлено в корзину',
            'cart_item' => $cart_item
        ], 201);
    }

    public function delete($product_id)
    {

        $cart_item = auth()->user()->cart()->where('product_id', $product_id)->first();

        $cart_item->delete();

        return response()->json([
            'message' => 'товар удален из корзины',
            'cart' => auth()->user()->cart
        ]);
    }

    public function clearAll()
    {
        auth()->user()->cart()->delete();

        return response()->json([
            'message' => 'корзина очищена',
            'cart' => auth()->user()->cart
        ]);
    }


    //update qty ($value) of product ($product_id) in cart

    public function changeQty(Request $request, $product_id)
    {
        $cart_item = auth()->user()->cart()->where('product_id', $product_id)->first();
        if (!$cart_item) return false;

        $newQty = $cart_item->qty += $request->value;

        if ($newQty == 0) {
            return $this->delete($product_id);
        }

        $cart_item->price = Product::find($product_id)->price * $newQty;

        return response()->json([
            'message' => 'изменено кол-во товара в корзине',
            'cart_item' => $cart_item
        ]);
    }


}
