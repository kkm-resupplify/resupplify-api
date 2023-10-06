<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;

class LoginDto extends BasicDto
{
    #[Max(60)]
    public string $name;

    #[Max(100)]
    public string $shortDescription;

    #[Max(300)]
    public string $description;
}
