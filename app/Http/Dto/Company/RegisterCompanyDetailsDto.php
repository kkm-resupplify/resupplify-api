<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;


class RegisterCompanyDetailsDto extends BasicDto
{
  #[Max(100)]
  public string $address;
  
  #[Email]
  public string $email;
  
  #[Numeric]
  public string $phoneNumber;
  
  #[Max(300)]
  public string $logo;
  
  #[Max(60)]
  public string $externalWebsite;
  
  #[Numeric]
  #[Max(60)]
  public string $countryId;
  
  #[Numeric]
  public string $companyCategoryId;

  #[Numeric]
  public string $tin;


    
}


