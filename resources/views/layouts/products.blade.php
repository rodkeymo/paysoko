@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1>Products</h1>
<div>
    @foreach ($products as $product)
        <div>
            <h2>{{ $product['name'] }}</h2>
            <p>{{ $product['price'] }} USD</p>
            <form action="/cart/add" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
