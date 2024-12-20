<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Redis;

class OrderTest extends TestCase
{
    public function it_can_place_an_order()
    {
        // Simulate cart items in Redis
        $cartKey = "cart:user:1";
        Redis::hset($cartKey, 1, json_encode([
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ]));

        $payload = [
            'customer_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'total_price' => 40.0
        ];

        $response = $this->postJson('/api/orders/place', $payload);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Order placed successfully']);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'total_price' => 40.0
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ]);

        // Verify the cart is cleared
        $cartItems = Redis::hgetall($cartKey);
        $this->assertEmpty($cartItems);
    }

    /** @test */
    public function it_can_view_orders()
    {
        // Create an order
        $order = Order::factory()->create([
            'customer_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'total_price' => 40.0
        ]);

        // Create an order item
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'orders' => [
                         '*' => [
                             'id',
                             'customer_name',
                             'email',
                             'total_price',
                             'items' => [
                                 '*' => [
                                     'product_name',
                                     'quantity',
                                     'price'
                                 ]
                             ]
                         ]
                     ]
                 ]);
    }
}

