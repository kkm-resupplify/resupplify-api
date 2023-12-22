<?php

namespace App\Resources\Product;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Models\Product\ProductOffer;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPositionInWarehouse extends JsonResource
{
    public function toArray($request)
    {
        $product = Product::find($this->product_id);
        $productWarehouses = Warehouse::find($this->warehouse_id);
        $productOffers = ProductOffer::where('company_product_id', $this->id)->get();
        $datesActive = [];
        foreach ($productOffers as $productOffer) {
            $datesActive[] = [
                'startsAt' => $productOffer->started_at->format('d-m-Y H:i:s'),
                'endsAt' => $productOffer->ended_at->format('d-m-Y H:i:s'),
            ];
        }

        return [
            'id' => $this->id,
            'product' => new ProductResource($product),
            'warehouseName' => $productWarehouses->name,
            'warehouseQuantity' => $this->quantity,
            'datesActive' => $datesActive,
        ];
    }
}
