<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function store(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $shipping = ShippingMethod::findOrFail($id);
        $cart = \Cart::session($userId);

        if (empty($cart->getConditions()->toArray())) {
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => $shipping->name,
                'type' => 'shipping',
                'target' => 'total',
                'value' => $shipping->price->amount(),
                'attributes' => array(
                    'shipping_id' => $shipping->id,
                )
            ));

            $cart->condition($condition);

            return redirect()->route('cart.index');
        } else {
            if ($cart->getCondition($shipping->name) != null) {
                if ($shipping->name === $cart->getCondition($shipping->name)->getName()) {
                    return redirect()->route('cart.index');
                }
            } else {
                foreach ($cart->getConditions()->toArray() as $condition) {
                    $cart->removeCartCondition($condition->getName());
                }

                $newCondition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => $shipping->name,
                    'type' => 'shipping',
                    'target' => 'total',
                    'value' => $shipping->price->amount(),
                    'attributes' => array(
                        'shipping_id' => $shipping->id,
                    )
                ));

                $cart->condition($newCondition);

                return redirect()->back();
            }
        }
    }
}
