<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Max;


class ProductTagDto extends BasicDto
{
    #[Max(60)]
    public string $name;
    #[Max(60)]
    public string $color;

}
