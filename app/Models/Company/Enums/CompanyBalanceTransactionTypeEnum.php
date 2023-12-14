<?php

namespace App\Models\Company\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self WITHDRAWAL()
 * @method static self DEPOSIT()
 * @method static self SALE()
 * @method static self PURCHASE()
 */
final class CompanyBalanceTransactionTypeEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'WITHDRAWAL' => 1,
            'DEPOSIT' => 2,
            'SALE' => 3,
            'PURCHASE' => 4
        ];
    }
}

