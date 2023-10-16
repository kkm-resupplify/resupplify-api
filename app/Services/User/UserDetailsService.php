<?php

namespace App\Services\User;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;


class UserDetailsService extends BasicService
{
    public function createUserData(PortalRegisterDto $request)
    {
        $user = Auth::user();
        // TODO: Write custom rule
        $user = UserDetails::create([
            'email' => $request->email,
            'password' => $request->password,
            'type' => UserTypeEnum::PORTAL(),
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
    
}
