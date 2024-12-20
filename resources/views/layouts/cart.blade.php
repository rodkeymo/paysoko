@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<h1>Your Cart</h1>
@if (count($cartItems) > 0)
    <ul>
        @foreach ($cartItems as $item)
            <li>
                {{ $item['name'] }} - {{ $item['quantity'] }} x ${{ $item['price'] }}
                <form action="/cart/remove" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <button type="submit">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
    <p>Total: ${{ $total }}</p>
    <form action="/checkout" method="POST">
        @csrf
        <button type="submit">Checkout</button>
    </form>
@else
    <p>Your cart is empty.</p>
@endif
@endsection
