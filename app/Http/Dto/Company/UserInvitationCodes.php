<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Date;


class UserInvitationCodes extends BasicDto
{

  #[Numeric]
  public string $roleId;

  #[Numeric]
  public string $companyId;

  #[Date]
  public string $expiryDate;

}


