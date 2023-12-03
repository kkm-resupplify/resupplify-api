<?php

namespace App\Http\Dto\User;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Attributes\Validation\Required;


class UserDetailsDto extends BasicDto
{
    #[Required]
    public string $firstName;

    #[Required]
    public string $lastName;

    #[Required]
    public string $phoneNumber;

    #[Required]
    #[DateFormat('d-m-Y')]
    public string $birthDate;

    #[Required]
    public string $sex;

}
