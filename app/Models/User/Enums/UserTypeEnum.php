<?php

namespace App\Models\User\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PORTAL()
 * @method static self BACK_OFFICE()
 */
final class UserTypeEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'PORTAL' => 1,
            'BACK_OFFICE' => 2,
        ];
    }
}
