<?php

namespace App\Http\Dto\Order;

use App\Http\Dto\BasicDto;
use App\Models\Order\Enums\OrderStatusEnum;
use Spatie\LaravelData\Attributes\Validation\Min;


class OrderStatusDto extends BasicDto
{
    #[Min(1)]
    public int $orderId;
    #[Min(1)]
    public int $status;

}
