<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;

use App\Models\User\User;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;


class UserInvitationCodes extends BasicDto
{

    public function __construct(
        #[Numeric]
        public int $roleId,
        #[Numeric]
        public int $companyId,
        // #[WithCast(DateTimeInterfaceCast::class, timeZone: 'UTC')]
        // public DateTimeInterface $expiryDate,
    ){}
}


