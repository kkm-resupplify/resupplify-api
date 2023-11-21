<?php

namespace App\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
        ];
    }
}
