<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Rule;

class ProductOfferDto extends BasicDto
{
    #[Min(1)]
    public int $productId;
    #[Rule(['required', 'regex:/^(0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*)$/'])]
    public int $warehouseId;
    public float $price;
    #[Min(1)]
    public int $productQuantity;
    public int $status;

}
