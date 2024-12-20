<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Redis;


class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email'
        ]);

        $cartKey = "cart:user:1";
        $cartItems = Redis::hgetall($cartKey);

        if (empty($cartItems)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalPrice = 0;
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'total_price' => $totalPrice
        ]);

        foreach ($cartItems as $key => $value) {
            $item = json_decode($value, true);
            $totalPrice += $item['price'] * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Update order total and clear the cart
        $order->update(['total_price' => $totalPrice]);
        Redis::del($cartKey);

        return response()->json(['message' => 'Order placed successfully'], 201);
    }

    public function index()
    {
        $orders = Order::with('items')->get();

        return response()->json(['orders' => $orders]);
    }
}