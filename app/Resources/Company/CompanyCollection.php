<?php

namespace App\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
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
