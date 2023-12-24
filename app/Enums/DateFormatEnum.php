<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self LONG()
 * @method static self SHORT()
 * @method static self API()
 * @method static self DATABASE()
 */
final class DateFormatEnum extends Enum
{
  protected static function values(): array
  {
    return [
      'LONG' => 'd-m-Y H:i:s',
      'SHORT' => 'd-m-y',
      'API' => 'Y-m-d\TH:i:sP',
      'DATABASE' => 'Y-m-d H:i:s',
    ];
  }
}
