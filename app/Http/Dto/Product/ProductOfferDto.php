<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;

class ProductOfferDto extends BasicDto
{
    #[Min(1)]
    public int $productId;
    #[Min(0.01)]
    public float $price;
    #[Min(1)]
    public int $offertQuantity;
    public int $status;

}
