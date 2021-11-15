<?php

namespace App\Http\Middleware\Cart;

use App\Cart\Cart;
use Closure;
use Illuminate\Http\Request;

class Sync
{
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->cart->sync();

        if($this->cart->hasChanged()) {
            return response()->json([
                'message' => 'Oh no, some items in your cart have changed. Please review these changes before placing your order.'
            ], 409);
        }

        return $next($request);
    }
}
