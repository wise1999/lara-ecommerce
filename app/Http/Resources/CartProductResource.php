<?php

namespace App\Http\Resources;

use App\Cart\Money;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'product' => new ProductIndexResource($this->product),
            'quantity' => $this->pivot->quantity,
            'total' => $this->getTotal()->formatted(),
        ]);
    }

    protected function getTotal() {
        return new Money($this->pivot->quantity * $this->price->amount());
    }
}
