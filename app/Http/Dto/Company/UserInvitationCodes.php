<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Numeric;


class UserInvitationCodes extends BasicDto
{

    public function __construct(
        #[Numeric]
        public int $roleId,
        // #[WithCast(DateTimeInterfaceCast::class, timeZone: 'UTC')]
        // public DateTimeInterface $expiryDate,
    ){}
}


