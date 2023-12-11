<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;


class CompanyTransactionDto extends BasicDto
{
    public float $amount;
    public string $currency;
    public int $type;
    public int $status;
    public ?int $senderId;
    public int $receiverId;
    public int $paymentMethodId;
}
