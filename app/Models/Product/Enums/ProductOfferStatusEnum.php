<?php

namespace App\Models\Product\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 */
final class ProductOfferStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'INACTIVE' => 0,
            'ACTIVE' => 1,
        ];
    }
}
