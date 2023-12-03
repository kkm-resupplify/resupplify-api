<?php

namespace App\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shortDescription' => $this->short_description,
            'description' => $this->description,
            'slug' => $this->slug,
            'ownerId' => $this->owner_id,
            'status' => $this->status,
            'details' => new CompanyDetailsResource($this->companyDetails),
        ];
    }
}
