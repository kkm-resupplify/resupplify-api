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
        $this->load('productOffers');
        return [
            'id' => $this->id,
            'seller' => $this->whenLoaded('seller', function () {
                return new CompanyResource($this->seller);
            }),
            'buyer' => $this->whenLoaded('buyer', function () {
                return new CompanyResource($this->buyer);
            }),
            'offers' => ProductOfferResource::collection($this->whenLoaded('productOffers')),
            'status' => $this->status,
            'createdAt' => $this->created_at->format(DateFormatEnum::LONG()),
            'updatedAt' => $this->updated_at->format(DateFormatEnum::LONG()),
        ];
    }
}
