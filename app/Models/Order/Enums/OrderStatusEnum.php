<?php

namespace App\Models\Order\Enums;

use Spatie\Enum\Laravel\Enum;
/**
 * @method static self PLACED()
 * @method static self PROCESSING()
 * @method static self SHIPPED()
 * @method static self INTRANSIT()
 * @method static self COMPLETED()
 * @method static self CANCELLED()
 * @method static self REFUNDED()
 * @method static self REJECTED()
 * @method static self SUSPENDED()
 * @method static self INACTIVE()
 */
final class OrderStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'PLACED' => 0,
            'PROCESSING' => 1,
            'SHIPPED' => 2,
            'INTRANSIT' => 3,
            'COMPLETED' => 4,
            'CANCELLED' => 5,
            'REFUNDED' => 6,
            'REJECTED' => 7,
            'SUSPENDED' => 8,
            'INACTIVE' => 9,
        ];
    }
}
