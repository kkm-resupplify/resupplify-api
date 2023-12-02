<?php

namespace App\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->languages[0]->pivot->name,
        ];
    }
}
