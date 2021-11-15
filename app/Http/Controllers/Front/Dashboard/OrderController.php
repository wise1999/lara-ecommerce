<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = $user->orders()->get();

        return Inertia::render('Front/Dashboard/Orders/Index', [
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'time' => $order->created_at->format('d.m.Y'),
                    'shipping' => $order->shippingMethod()->first(),
                    'status' => $order->status,
                    'subtotal' => $order->subtotal->formatted()
                ];
            }),
        ]);
    }

    public function show($id)
    {

        $order = Order::findOrFail($id);
        $shipping = $order->shippingMethod()->first();
        $orderedItems = ProductOrder::where('order_id', $order->id)->get();


        return Inertia::render('Front/Dashboard/Orders/Show', [
            'order' => [
                'id' => $order->id,
                'time' => $order->created_at->format('d.m.Y'),
                'shipping' => [
                    'id' => $shipping->id,
                    'name' => $shipping->name,
                    'price' => $shipping->price->formatted(),
                ],
                'status' => $order->status,
                'subtotal' => $order->subtotal->formatted()
            ],
            'address' => $order->address()->with('country')->first(),
            'products' => $orderedItems->map(function ($orderedProduct) {
                $product = Product::findOrFail($orderedProduct->product_id);
                return [
                    'quantity' => $orderedProduct->quantity,
                    'thumbnail' => $product->images->first(),
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->formattedPrice,
                    'slug' => $product->slug,
                ];
            }),
        ]);
    }
}
