<?php

namespace App\Services\Company;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Services\BasicService;

class CompanyService extends BasicService
{
    public function createCompany()
    {
    }
}
