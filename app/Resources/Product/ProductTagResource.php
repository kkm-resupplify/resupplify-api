<?php

namespace App\Resources\Product;

use App\Resources\BasicResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductTagResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'productTagId' => $this->pivot->product_tag_id,
            'companyId' => $this->pivot->company_id,
            'product_id' => $this->pivot->product_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'color' => $this->color,

        ];
    }
}
