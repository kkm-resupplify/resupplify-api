<?php

namespace App\Http\Dto\Order;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Min;


class OrderDto extends BasicDto
{
    public array $order;
}
