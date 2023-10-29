<?php

namespace App\Resources\Company;

use App\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyMemberCollection extends ResourceCollection
{
    /**
        * Transform the resource collection into an array.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return array
        */
    public function toArray(Request $request)
    {
        return UserResource::collection($this);
    }


}
