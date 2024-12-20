<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        // Example API endpoint
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Failed to fetch products'], 500);
    }
}

