<?php

namespace App\Resources\Order;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\DateFormatEnum;
use App\Models\Company\Company;
use App\Resources\Company\CompanyResource;
use App\Resources\Product\ProductOfferResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $company = Company::find(1);
        $company ->load('companyDetails');
        $this->load('productOffers');
        return [
            'id' => $this->id,
            'company' => new CompanyResource($company),
            'offers' => ProductOfferResource::collection($this->whenLoaded('productOffers')),
            'status' => $this->status,
            'createdAt' => $this->created_at->format(DateFormatEnum::LONG()),
            'updatedAt' => $this->updated_at->format(DateFormatEnum::LONG()),
        ];
    }
}
