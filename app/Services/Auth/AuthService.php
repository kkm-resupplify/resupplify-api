<?php

namespace App\Services\Auth;

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
    public function login(LoginDto $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->throw(new FailedLoginException());
        }

        $user->tokens()->delete();
        $token = $user->createToken('marketify-token')->plainTextToken;

        // TODO: Add LoginResource
        return ['user' => $user, 'token' => $token];
    }

    public function portalRegister(PortalRegisterDto $request)
    {
        if (User::where('email', $request->email)->exists()) {
            $this->throw(new UserAlreadyExistsException());
        }

        // TODO: Write custom rule
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'type' => UserTypeEnum::PORTAL(),
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
