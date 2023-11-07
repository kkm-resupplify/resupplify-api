<?php

namespace App\Resources\Warehouse;

use App\Models\Product\Product;
use App\Resources\BasicResource;
use App\Resources\Product\ProductResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WarehouseProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => [
                'name' => $this->name,
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
