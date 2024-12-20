@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<h1>Your Orders</h1>
@if (count($orders) > 0)
    <ul>
        @foreach ($orders as $order)
            <li>
                Order #{{ $order->id }} - ${{ $order->total }} ({{ $order->created_at }})
                <ul>
                    @foreach ($order->items as $item)
                        <li>{{ $item->name }} - {{ $item->quantity }} x ${{ $item->price }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@else
    <p>No orders found.</p>
@endif
@endsection
