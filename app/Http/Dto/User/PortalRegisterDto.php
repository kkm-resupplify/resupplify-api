<?php

namespace App\Http\Dto\User;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;

class PortalRegisterDto extends BasicDto
{
    #[Email]
    #[Required]
    public string $email;

    #[Max(32)]
    #[Confirmed]
    #[Required]
    public string $password;
}
