<?php

namespace App\Http\Dto\Country;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;

class CountryDto extends BasicDto
{
    #[Required]
    public string $name;

    #[Max(3)]
    #[Min(2)]
    #[Required]
    public string $code;
}
