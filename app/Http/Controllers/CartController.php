<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'product_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric'
        ]);

        $cartKey = "cart:user:1"; // Example cart for user 1
        $product = [
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'price' => $request->price
        ];

        Redis::hset($cartKey, $request->product_id, json_encode($product));

        return response()->json(['message' => 'Product added to cart'], 201);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cartKey = "cart:user:1";
        Redis::hdel($cartKey, $request->product_id);

        return response()->json(['message' => 'Product removed from cart'], 200);
    }

    public function viewCart()
    {
        $cartKey = "cart:user:1";
        $cartItems = Redis::hgetall($cartKey);

        $cart = [];
        foreach ($cartItems as $key => $value) {
            $cart[] = json_decode($value, true);
        }

        return response()->json(['cart' => $cart]);
    }
}

