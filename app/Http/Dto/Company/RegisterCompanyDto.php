<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;


class RegisterCompanyDto extends BasicDto
{
    #[Max(60)]
    public string $name;

    #[Max(100)]
    public string $shortDescription;

    #[Max(300)]
    public string $description;

    #[Max(100)]
    public string $address;

    #[Email]
    public string $email;

    #[Numeric]
    public string $phoneNumber;

    #[Nullable]
    #[Max(300)]
    public string $logo;

    #[Max(60)]
    public string $externalWebsite;

    #[Numeric]
    #[Max(60)]
    public int $countryId;

    #[Numeric]
    public int $companyCategoryId;

    #[Required]
    public string $tin;
    
    #[Nullable]
    public string $contactPerson;

}
