<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Money;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Front\Cart\UpdateRequest;
use App\Models\Product;
use App\Models\ShippingMethod;
use Money\Parser\IntlMoneyParser;
use Money\Currencies\ISOCurrencies;
use Inertia\Inertia;
use PHPUnit\Framework\Constraint\IsEmpty;

use function PHPUnit\Framework\isEmpty;

class CartProductController extends Controller
{

    public function index() {
        $userId = auth()->user()->id;
        $cart = \Cart::session($userId);
        $cartArray = $cart->getContent()->sort()->toArray();

        if(empty($cartArray)) {
            $cart->clearCartConditions();
        }

        foreach($cart->getContent() as $item) {
            $productID = $item->associatedModel->id;
            $product = Product::findOrFail($productID);

            $quantity = $product->minStock($item->quantity);

                if($item->quantity != $quantity) {
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

        if(!empty($cart->getConditions()->sort()->toArray())) {
            $cartAttributes = collect($cart->getConditions()->first()->getAttributes());
            $cartShippingID = $cartAttributes->first();

            foreach($shippings as $shipping) {
                if($shipping['id'] === $cartShippingID) {
                    $currentShipping = $cartShippingID;
                }
            }
        } 
        
        return Inertia::render('Front/Cart/Index', [
            'cart' => $cartArray,
            'subtotal' => $cartSubtotal->formatted(),
            'total' => $cartTotal->formatted(),
            'shippings' => $shippings,
            'current_shipping' => $currentShipping,
        ]);
    }

    public function store(CartStoreRequest $request) {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);

        $rowId = $product->id;
        $userID = $validated['user_id'];
        $currentCart = \Cart::session($userID);

        $currentCart->add(array(
            'id' => $rowId,
            'name' => $product->name,
            'price' => $product->price->amount(),
            'quantity' => $product->minStock($validated['quantity']),
            'associatedModel' => $product,
            'attributes' => array(
                'first_image' => $product->firstImage,
                'formatted_price' => $product->formattedPrice,
                'product_stock' => $product->stockCount()
            )
        ));

        $currentCartContents = $currentCart->get($rowId);
        $quantity = $product->minStock($currentCartContents->quantity);

        if($currentCartContents->quantity !== $quantity) {
            $currentCart->update($rowId, [
                'quantity' => [
                 'relative' => false,
                 'value' => $quantity,
                ]
            ]);
        }

        return redirect()->back();
    }

    public function update(UpdateRequest $request, $id) {
        $validated = $request->validated();

        $userId = auth()->user()->id;

       \Cart::session($userId)->update($id, [
           'quantity' => [
            'relative' => false,
            'value' => $validated['quantity'],
           ]
       ]);

        return redirect()->back();
    } 

    public function destroy($id) {
        $userID = auth()->user()->id;

        \Cart::session($userID)->remove($id);

        return redirect()->back();
    }
}
