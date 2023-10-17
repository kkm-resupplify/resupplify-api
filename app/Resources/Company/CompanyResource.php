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
            'company' => [
                'name' => $this['company']->name,
                'shortDescription' => $this['company']->short_description,
                'description' => $this['company']->description,
                'slug' => $this['company']->slug,
                'ownerId' => $this['company']->owner_id,
                'countryId' => $this['companyDetails']->country_id,
                'address' => $this['companyDetails']->address,
                'email' => $this['companyDetails']->email,
                'phoneNumber' => $this['companyDetails']->phone_number,
                'externalWebsite' => $this['companyDetails']->external_website,
                'logo' => $this['companyDetails']->logo,
                'companyId' => $this['companyDetails']->company_id,
                'companyCategoryId' => $this['companyDetails']->company_category_id,
                'tin' => $this['companyDetails']->tin,
                'contactPerson' => $this['companyDetails']->contact_person,
            ],
        ];
    }
}
