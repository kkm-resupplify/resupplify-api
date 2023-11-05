<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;


class ProductDto extends BasicDto
{
    #[Max(60)]
    public string $name;
    #[Max(300)]
    public string $description;
    #[Max(90)]
    public string $producent;
    #[Max(90)]
    public string $code;
    #[Max(1)]
    public int $status;
    #[Max(1)]
    public int $verificationStatus;
    public int $productUnitId;
    public int $productSubcategoryId;

}
