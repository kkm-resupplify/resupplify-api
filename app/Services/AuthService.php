<?php

namespace App\Services;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\General\FailedLoginException;
use App\Exceptions\General\UserAlreadyExistsException;

class AuthService extends BasicService
{
    public function login(LoginDto $request)
    {
        if (!isset($userType)) {
            $userType = UserTypeEnum::PORTAL();
        }

        $user = User::where('email', '=', $request->email)
            ->where('type', $userType)
            ->first();

        if (!$user || Hash::check($request->password, $user->password)) {
            $this->throw(new FailedLoginException());
        }

        $user->tokens()->delete();
        $token = $user->createToken('marketify-token')->plainTextToken;

        // TODO: Add LoginResource
        return ['user' => $user, 'token' => $token];
    }

    public function portalRegister(PortalRegisterDto $request)
    {
        // TODO: Write custom rule
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => UserTypeEnum::PORTAL(),
        ]);

        if (User::where('email', $request->email)->exists()) {
            $this->throw(new UserAlreadyExistsException());
        }

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
