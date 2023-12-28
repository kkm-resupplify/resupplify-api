<?php

namespace App\Resources\Order;

use Illuminate\Http\Request;
use App\Resources\Product\ProductOfferResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       
        return [
            'quantity' => $this->pivot->offer_quantity,
            'offer' => new ProductOfferResource($this)
        ];
    }
}
