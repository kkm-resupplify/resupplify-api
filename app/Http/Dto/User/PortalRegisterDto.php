<?php

namespace App\Http\Dto\User;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Confirmed;

class PortalRegisterDto extends BasicDto
{
    #[Email]
    public string $email;

    #[Max(32)]
    #[Confirmed]
    public string $password;
}
