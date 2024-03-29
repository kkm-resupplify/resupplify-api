<?php

namespace App\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\DateFormatEnum;
use App\Resources\Company\CompanyResource;

class ProductOfferResource extends JsonResource
{
    public function toArray($request)
    {
        $this->load('product');
        return [
            'id' => $this->id,
            'company' => $this->whenLoaded('company', function () {
                return new CompanyResource($this->company);
            }),
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
