<?php

namespace App\Resources\User;

use App\Resources\BasicResource;
use App\Resources\Company\CompanyResource;

class UserLoginResource extends BasicResource
{
    public function toArray($request)
    {
        return [
            'user' => [
                'id' => $this['user']->id,
                'email' => $this['user']->email,
                'type' => $this['user']->type,
                'createdAt' => $this['user']->created_at,
                'details' => new UserDetailsResource(
                    $this['user']->userDetails
                ),
                'company' => new CompanyResource($this['user']->company),
            ],
            'token' => $this['token'],
        ];
    }
}
