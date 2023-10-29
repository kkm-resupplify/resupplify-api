<?php

namespace App\Resources\User;

use App\Resources\BasicResource;
use App\Resources\Company\CompanyResource;
use App\Resources\Roles\RoleResource;

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
                'roles' => RoleResource::collection($this['user']->roles),
            ],
            'token' => $this['token'],
        ];
    }
}
