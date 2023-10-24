<?php

namespace App\Resources\Company;

use App\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyUserCollection extends ResourceCollection
{
    /**
        * Transform the resource collection into an array.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return array
        */
    public function toArray(Request $request): array
    {
        return [
            'users' => UserResource::collection($this),
        ];
    }


}
