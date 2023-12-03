<?php

namespace App\Resources\Warehouse;

use App\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WarehouseProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => [
                'name' => Product::find($this['pivot']->product_id)->languages[Auth::user()->language->id-1]->pivot->name,
                'status' => $this->status,
                'verificationStatus' => $this->verification_status,
                'code' => $this->code,
            ],
            'status' => $this['pivot']->status,
            'quantity' => $this['pivot']->quantity,
            'safeQuantity' => $this['pivot']->safe_quantity,
        ];
    }
}
