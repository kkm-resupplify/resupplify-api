<?php

namespace App\Resources\HomePage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Company\CompanyDetailsResource;

class HomePageCompanyResource extends JsonResource
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
            'offersTotal' => (int) $this->offersActive,
            'uniqueClientsCount' => (int) $this->uniqueClientsCount,
            'productsSold' => $this->productsSold,
        ];
    }
}
