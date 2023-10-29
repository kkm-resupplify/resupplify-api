<?php

namespace App\Services\Auth;

use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Models\User\User;
use App\Models\User\UserDetails;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Services\BasicService;
use App\Resources\User\UserLoginResource;

class AuthService extends BasicService
{
    public function login(LoginDto $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->throw(new FailedLoginException());
        }
        if(isset($user->company))
        {
            setPermissionsTeamId($user->company->id);
        }
        $user->tokens()->delete();
        $token = $user->createToken('marketify-token')->plainTextToken;
        $user->details = UserDetails::where('user_id', '=', $user->id)->first();
        $response = ['user' => $user, 'token' => $token];
        return new UserLoginResource($response);
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
