<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;


class ProductTagDto extends BasicDto
{
    #[Max(60)]
    public string $name;
    #[Max(60)]
    public string $color;

}
