<?php

namespace App\Services\User;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Http\Dto\User\UserDetailsDto;
use App\Models\User\User;
use App\Models\User\UserDetails;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;


class UserDetailsService extends BasicService
{
    public function creatUserData(UserDetailsDto $request)
    {
        $user = Auth::user();
        $user = UserDetails::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'phone_number' => $request->phoneNumber,
            'birth_date' => $request->birthDate,
            'sex' => $request->sex,
            'user_id' => $user->id,
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

}
