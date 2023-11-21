<?php

namespace App\Http\Dto\Warehouse;

use App\Http\Dto\BasicDto;

class WarehouseProductDto extends BasicDto
{
    public int $quantity;
    public int $safeQuantity;
    public ?int $status;
    public ?int $warehouseId;
    public ?int $productId;

}
