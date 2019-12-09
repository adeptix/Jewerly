<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;


class PurchaseController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return response()->json([
                    'message' => 'Вы не авторизованы'
                ], 401);
            }

            return $next($request);
        })->only('history');

        $this->middleware('user.admin_status')->only('index');
    }

    public function index()
    {
        return Purchase::all();
    }


    public function authBuy(PurchaseRequest $request)
    {

        $purchase = Purchase::create(
            $request->validated() + ['user_id' => auth()->user()->id]
        );
        Product::find($request->product_id)->increment('buy_qty');


        return response()->json([
            'message' => 'success auth',
            'purchase' => $purchase
        ], 201);
    }

    public function guestBuy(PurchaseRequest $request)
    {
        $purchase = Purchase::create(
            $request->validated() + ['user_id' => null]
        );
        Product::find($request->product_id)->increment('buy_qty');

        return response()->json([
            'message' => 'success guest',
            'purchase' => $purchase
        ], 201);
    }


    public function history()
    {
        $history = auth()->user()->purchases()->get();

        return response()->json([
            'history' => $history
        ]);
    }


}
