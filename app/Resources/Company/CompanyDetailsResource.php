<?php

namespace App\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'countryId' => $this->country_id,
            'address' => $this->address,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'externalWebsite' => $this->external_website,
            'logo' => $this->logo,
            'companyId' => $this->company_id,
            'companyCategoryId' => $this->company_category_id,
            'tin' => $this->tin,
            'contactPerson' => $this->contact_person,
        ];
    }
}
