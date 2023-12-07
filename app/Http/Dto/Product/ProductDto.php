<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;

class ProductDto extends BasicDto
{
    #[Max(90)]
    public string $producer;
    #[Max(90)]
    public string $code;
    public int $productUnitId;
    public int $productSubcategoryId;
    public array $translations;
    public ?array $productTagsId;
    public ?int $status;

}
