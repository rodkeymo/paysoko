<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Redis;

class CartTest extends TestCase
{
    protected $cartKey;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartKey = "cart:user:1"; // Example cart key for user 1
    }

    /** @test */
    public function it_can_add_items_to_the_cart()
    {
        $payload = [
            'product_id' => 1,
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ];

        $response = $this->postJson('/api/cart/add', $payload);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Product added to cart']);

        $cartItems = Redis::hgetall($this->cartKey);
        $this->assertArrayHasKey($payload['product_id'], $cartItems);
    }

    /** @test */
    public function it_can_remove_items_from_the_cart()
    {
        // Add an item first
        Redis::hset($this->cartKey, 1, json_encode([
            'product_id' => 1,
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ]));

        // Remove the item
        $response = $this->postJson('/api/cart/remove', ['product_id' => 1]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product removed from cart']);

        $cartItems = Redis::hgetall($this->cartKey);
        $this->assertEmpty($cartItems);
    }

    /** @test */
    public function it_can_view_cart_items()
    {
        // Add items to the cart
        Redis::hset($this->cartKey, 1, json_encode([
            'product_id' => 1,
            'product_name' => 'Sample Product',
            'quantity' => 2,
            'price' => 20.0
        ]));

        $response = $this->getJson('/api/cart/items');

        $response->assertStatus(200)
                 ->assertJsonStructure(['cart']);
    }
}
