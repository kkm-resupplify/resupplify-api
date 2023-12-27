<?php

namespace App\Resources\Order;

use Illuminate\Http\Request;
use App\Enums\DateFormatEnum;
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
        $this->load('orderItems');
        return [
            'id' => $this->id,
            'seller' => $this->whenLoaded('seller', function () {
                return new CompanyResource($this->seller);
            }),
            'buyer' => $this->whenLoaded('buyer', function () {
                return new CompanyResource($this->buyer);
            }),
            'orderItems' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'status' => $this->status,
            'createdAt' => $this->created_at->format(DateFormatEnum::LONG()),
            'updatedAt' => $this->updated_at->format(DateFormatEnum::LONG()),
        ];
    }
}
