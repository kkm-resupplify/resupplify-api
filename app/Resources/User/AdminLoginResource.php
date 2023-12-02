<?php

namespace App\Resources\User;

use App\Resources\Roles\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminLoginResource extends JsonResource
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
                'roles' => RoleResource::collection($this['user']->roles),
            ],
            'token' => $this['token'],
        ];
    }
}
