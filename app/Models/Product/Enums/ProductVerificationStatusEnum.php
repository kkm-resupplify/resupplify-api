<?php

namespace App\Models\Product\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self UNVERIFIED()
 * @method static self VERIFIED()
 * @method static self REJECTED()
 */
final class ProductVerificationStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'UNVERIFIED' => 0,
            'VERIFIED' => 1,
            'REJECTED' => 2,
        ];
    }
}
