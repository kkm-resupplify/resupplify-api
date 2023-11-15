<?php

namespace App\Http\Dto\Warehouse;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\In;

class WarehouseProductMassStatusUpdateDto extends BasicDto
{

    public function __construct(
        public array $warehouseProductIds,
        #[In([0, 1])]
        public int $newStatus,
        public int $warehouseId
    ) {
    }
}
