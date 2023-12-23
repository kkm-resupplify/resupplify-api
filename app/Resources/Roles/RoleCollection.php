<?php

namespace App\Resources\Roles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleCollection extends JsonResource
{
    /**
        * Transform the resource collection into an array.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return array
    */
    public function toArray(Request $request): array
    {
        return $this->resource->toArray();
    }
}
