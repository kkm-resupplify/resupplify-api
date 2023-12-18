<?php

namespace App\Resources\Product;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPositionInWarehouse extends JsonResource
{
    public function toArray($request)
    {
        $product = Product::find($this->product_id);
        $productWarehouses = Warehouse::find($this->warehouse_id);
        $productOffers = $product->productOffers??null;
        return [
            'id' => $this->id,
            'product' =>new ProductResource($product),
            'warehouseName' => $productWarehouses->name,
            'warehouseQuantity' => $this->quantity,
            'datesActive' => $productOffers
            // 'startsAt' => $this->started_at->format('d-m-Y H:i:s') ?? null,
            // 'endsAt' => $this->ended_at->format('d-m-Y H:i:s') ?? null,
        ];
    }
}
