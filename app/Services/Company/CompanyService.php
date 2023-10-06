<?php

namespace App\Services\Company;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\General\FailedLoginException;
use App\Exceptions\General\UserAlreadyExistsException;
use App\Services\BasicService;

class AuthService extends BasicService
{

}