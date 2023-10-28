<?php

namespace App\Resources\User;

use App\Resources\BasicResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'type' => $this->type,
            'createdAt' => $this->created_at,
            'userDetails' => new UserDetailsResource($this->userDetails),
            'userRoles' => RoleResource::collection($this->roles),
        ];
    }
}
