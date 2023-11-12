<?php

namespace App\Resources\Warehouse;

use App\Models\Product\Product;
use App\Resources\BasicResource;
use App\Resources\Product\ProductResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WarehouseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'products' => WarehouseProductResource::collection($this->products),
        ];
    }
}
