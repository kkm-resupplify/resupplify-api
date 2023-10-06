<?php

namespace App\Models\Company\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self UNVERIFIED()
 * @method static self VERIFIED()
 * @method static self SUSPENDED()
 * @method static self INACTIVE()
 */
final class CompanyStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'UNVERIFIED' => 0,
            'VERIFIED' => 1,
            'SUSPENDED' => 2,
            'INACTIVE' => 3,
        ];
    }
}
