<?php

namespace App\Http\Dto\Warehouse;

use App\Http\Dto\BasicDto;
use App\Models\Product\Enums\ProductStatusEnum;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\InArray;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Optional;



class WarehouseProductDto extends BasicDto
{
    public int $quantity;
    public int $safeQuantity;
    public int|optional $status;
    public int|optional $warehouseId;
    public int|optional $productId;

}
