<?php

namespace App\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\DateFormatEnum;

class ProductOfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'productQuantity' => $this->product_quantity,
            'warehouseQuantity' => $this->productWarehouse->quantity,
            'status' => $this->status,
            'createdAt' => $this->created_at->format(DateFormatEnum::LONG()),
            'updatedAt' => $this->updated_at->format(DateFormatEnum::LONG()),
            'startsAt' => $this->started_at->format(DateFormatEnum::LONG()),
            'endsAt' => $this->ended_at->format(DateFormatEnum::LONG()),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
