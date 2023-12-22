<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;


class TransactionDto extends BasicDto
{
    public int $companyBalanceId;
    public string $currency;
    public float $amount;
    public int $type;
    public int $status;
    public ?int $senderId;
    public int $receiverId;
    public int $paymentMethodId;

    public function __construct(
        int $companyBalanceId,
        string $currency,
        float $amount,
        int $type,
        int $status,
        ?int $senderId,
        int $receiverId,
        int $paymentMethodId
    ) {
        $this->companyBalanceId = $companyBalanceId;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->type = $type;
        $this->status = $status;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->paymentMethodId = $paymentMethodId;
    }
}
