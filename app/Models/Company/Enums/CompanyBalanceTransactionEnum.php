<?php

namespace App\Models\Company\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PENDING()
 * @method static self APPROVED()
 * @method static self REJECTED()
 * @method static self REFUNDED()
 * @method static self PROCESSING()
 * @method static self CANCELED()
 * @method static self SUSPENDED()
 * @method static self ERROR()
 */
final class CompanyBalanceTransactionEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'PENDING' => 1,
            'APPROVED' => 2,
            'REJECTED' => 3,
            'REFUNDED' => 4,
            'PROCESSING' => 5,
            'CANCELED' => 6,
            'SUSPENDED' => 7,
            'ERROR' => 8,
        ];
    }
}

