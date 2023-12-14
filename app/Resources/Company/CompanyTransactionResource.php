<?php

namespace App\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Payment\PaymentEntityResource;

class CompanyTransactionResource extends JsonResource
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
            'companyBalanceId' => $this->company_balance_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'type' => $this->type,
            'status' => $this->status,
            'paymentMethodId' => $this->payment_method_id,
            'receiver' => new PaymentEntityResource($this->receiver),
            // 'sender' => new PaymentEntityResource($this->sender),
            'createdAt' => $this->created_at->format('d-m-Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
