<?php

namespace App\Models\Warehouse\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 */
final class WarehouseStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'ACTIVE' => 0,
            'INACTIVE' => 1,
        ];
    }
}
