<?php

namespace App\Models\Product\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 * @method static self DELETED()
 */
final class ProductStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'INACTIVE' => 0,
            'ACTIVE' => 1,
            'DELETED' => 2,
        ];
    }
}
