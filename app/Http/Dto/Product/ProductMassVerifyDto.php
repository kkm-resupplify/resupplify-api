<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\In;

class ProductMassVerifyDto extends BasicDto
{

    public function __construct(
        public array $productIds,
        #[In([0, 1, 2])]
        public int $newStatus
    ) {
    }
}
