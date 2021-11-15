<?php

namespace App\Http\Middleware\Cart;

use App\Cart\Cart;
use Closure;
use Illuminate\Http\Request;

class ResponseIfEmpty
{
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function handle(Request $request, Closure $next)
    {
        if($this->cart->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 400);
        }
        return $next($request);
    }
}
