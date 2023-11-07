<?php

namespace App\Http\Dto\Warehouse;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;


class WarehouseProductDto extends BasicDto
{
    public int $quantity;

    public int $safeQuantity;
}
