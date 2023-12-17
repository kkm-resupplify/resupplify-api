<?php

namespace App\Resources\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'companyProductId' => $this->company_product_id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'price' => $this->price,
            'productQuantity' => $this->product_quantity,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d-m-Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
