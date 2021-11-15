<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => Product::all()->map(function ($product) {
                return [
                    'first_image' => $product->firstImage,
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->formattedPrice,
                    'slug' => $product->slug,
                ];
            }),
        ]);
    }
}
