<?php

namespace App\Http\Dto\User;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;

class LoginDto extends BasicDto
{
    #[Email]
    public string $email;

    #[Max(32)]
    public string $password;
}