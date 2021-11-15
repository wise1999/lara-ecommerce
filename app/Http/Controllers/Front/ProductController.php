<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show($slug) {
        $product = Product::where('slug', $slug)
            ->first();

        return Inertia::render('Front/SingleProduct', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->price,
                'price' => $product->formattedPrice,
                'images' => $product->images,
                'categories' => $product->categories,
                'stock_count' => $product->stockCount(),
                'in_stock' => $product->inStock(),
            ],
        ]);
    }
}
