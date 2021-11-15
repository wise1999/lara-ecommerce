<?php

namespace App\Http\Controllers\Order;

use App\Cart\Money;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Checkout\StoreOrderRequest;
use App\Models\Address;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ShippingMethod;
use App\Models\Stock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $userId = $user->id;
        $cart = \Cart::session($userId);
        $cartArray = $cart->getContent()->sort()->toArray();

        if (empty($cartArray)) {
            $cart->clearCartConditions();
        }

        foreach ($cart->getContent() as $item) {
            $productID = $item->associatedModel->id;
            $product = Product::findOrFail($productID);

            $quantity = $product->minStock($item->quantity);

            if ($item->quantity != $quantity) {
                $cart->update($item->id, [
                    'quantity' => [
                        'relative' => false,
                        'value' => $quantity,
                    ]
                ]);
            }
        }

        $cartSubtotal = (int)$cart->getSubTotal();
        $cartSubtotal = new Money($cartSubtotal);

        $cartTotal = (int)$cart->getTotal();
        $cartTotal = new Money($cartTotal);

        $shippings = ShippingMethod::all()->map(function ($shipping) {
            return [
                'id' => $shipping->id,
                'price' => $shipping->price->amount(),
                'formatted' => $shipping->formattedPrice,
                'name' => $shipping->name
            ];
        });

        $currentShipping = '';

        if (!empty($cart->getConditions()->sort()->toArray())) {
            $cartAttributes = collect($cart->getConditions()->first()->getAttributes());
            $cartShippingID = $cartAttributes->first();

            foreach ($shippings as $shipping) {
                if ($shipping['id'] === $cartShippingID) {
                    $currentShipping = $cartShippingID;
                }
            }
        }

        return Inertia::render('Front/Checkout/Index', [
            'addresses' => $user->addresses()->with('country')->get(),
            'current_address' => $user->addresses()->where('default', true)->with('country')->first(),
            'countries' => Country::all(),
            'cart' => $cartArray,
            'subtotal' => $cartSubtotal->formatted(),
            'total' => $cartTotal->formatted(),
            'shippings' => $shippings,
            'current_shipping' => $currentShipping,
        ]);
    }

    public function setAddress($id)
    {
        $addresses = Address::all();
        foreach ($addresses as $address) {
            $address->update(['default' => false]);
        }

        $newAddress = Address::findOrFail($id);
        $newAddress->update(['default' => true]);

        return redirect()->back();
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

        $userId = $user->id;
        $cart = \Cart::session($userId);
        $cartArray = $cart->getContent()->sort()->toArray();

        if (empty($cartArray)) {
            $cart->clearCartConditions();
        }

        $cartSubtotal = (int)$cart->getSubTotal();
        $cartSubtotal = new Money($cartSubtotal);

        $order = Order::create([
            'user_id' => $userId,
            'address_id' => $validated['address_id'],
            'shipping_method_id' => $validated['shipping_method_id'],
            'status' => Order::PENDING,
            'subtotal' => $cartSubtotal->amount(),
        ]);

        foreach ($cart->getContent() as $key => $item) {
            $productID = $item->associatedModel->id;
            $product = Product::findOrFail($productID);
            $quantity = $product->minStock($item->quantity);


            if ($item->quantity != $quantity) {
                $cart->update($item->id, [
                    'quantity' => [
                        'relative' => false,
                        'value' => $quantity,
                    ]
                ]);
            }

            ProductOrder::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
            ]);

            if (!$order->status !== 'payment_failed') {
                $productStock = Stock::where('product_id', $item->id)->first();

                $productStock->update([
                    'quantity' => $productStock->quantity - $item->quantity,
                ]);
            }
        }

        $cart->clear();

        if (empty($cartArray)) {
            $cart->clearCartConditions();
        }

        return Inertia::render('Front/Checkout/ThankYou');
    }
}
