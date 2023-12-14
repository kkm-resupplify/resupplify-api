<?php

namespace App\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentEntityResource extends JsonResource
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
      'email' => $this->email,
      'phoneNumber' => $this->companyDetails->phone_number,
      'address' => $this->companyDetails->address,
      'contactPerson' => $this->companyDetails->contact_person,
    ];
  }
}
