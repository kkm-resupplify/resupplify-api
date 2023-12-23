<?php

namespace App\Resources\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

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
