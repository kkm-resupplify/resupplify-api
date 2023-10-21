<?php

namespace App\Resources\User;

use App\Resources\BasicResource;

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
                'details' => $this['user']->details,
            ],
            'token' => $this['token'],
        ];
    }
}
