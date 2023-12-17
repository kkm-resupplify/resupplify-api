<?php

namespace App\Resources\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'price' => $this->price,
            'productQuantity' => $this->product_quantity,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d-m-Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d-m-Y H:i:s'),
            'startsAt' => $this->started_at->format('d-m-Y H:i:s'),
            'endsAt' => $this->ended_at->format('d-m-Y H:i:s'),
        ];
    }
}
