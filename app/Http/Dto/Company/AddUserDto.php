<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;


class AddUserDto extends BasicDto
{

    public function __construct(
        public string $invitationCode,

    ){}
}


