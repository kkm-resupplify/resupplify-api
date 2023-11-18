<?php

namespace App\Resources\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductProductTagResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'productTagId' => $this->pivot->product_tag_id,
            'companyId' => $this->company_id,
            'product_id' => $this->pivot->product_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'color' => $this->color,
        ];
    }
}
