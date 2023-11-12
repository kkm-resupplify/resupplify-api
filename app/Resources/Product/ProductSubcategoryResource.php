<?php

namespace App\Resources\Product;

use App\Resources\BasicResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductSubcategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->languages[0]->pivot->name,
        ];
    }
}
