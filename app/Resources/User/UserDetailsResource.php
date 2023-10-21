<?php

namespace App\Resources\User;

use App\Resources\BasicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return[
                'firstName' => $this->first_name,
                'lastName' => $this->last_name,
                'phoneNumber' => $this->phone_number,
                'birthDate' => $this->birth_date,
                'sex' => $this->sex,
            ];
    }
}
