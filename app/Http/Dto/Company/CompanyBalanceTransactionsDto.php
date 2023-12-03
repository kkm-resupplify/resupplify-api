<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;


class CompanyBalanceTransactionsDto extends BasicDto
{
    public int $companyId;
    public float $amount;
    public int $type;
}
