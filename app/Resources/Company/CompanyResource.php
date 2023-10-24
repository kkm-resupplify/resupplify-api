<?php

namespace App\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Company\CompanyDetailsResource;
use Illuminate\Support\Str;

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
            'name' => $this->name,
            'shortDescription' => $this->short_description,
            'description' => $this->description,
            'slug' => $this->slug,
            'ownerId' => $this->owner_id,
            'company_details' => new CompanyDetailsResource($this->companyDetails),
        ];
    }
}
