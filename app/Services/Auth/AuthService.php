<?php

namespace App\Services\Auth;

use App\Models\User\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Hash;

use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;

use App\Exceptions\Auth\FailedLoginException;
use App\Exceptions\User\UserAlreadyExistsException;

use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Http\Dto\User\BackOfficeRegisterDto;

use App\Services\BasicService;

use App\Resources\User\UserLoginResource;
use App\Resources\User\AdminLoginResource;

class AuthService extends BasicService
{
    public function login(LoginDto $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->throw(new FailedLoginException());
        }
        if (isset($user->company)) {
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
            'language_id' => 1,
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function backOfficeRegister(BackOfficeRegisterDto $request)
    {
        if (User::where('email', $request->email)->exists()) {
            $this->throw(new UserAlreadyExistsException());
        }

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'type' => UserTypeEnum::BACK_OFFICE(),
            'language_id' => 1,
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function backOfficeLogin(LoginDto $request)
    {
        $user = User::where('email', '=', $request->email)
            ->where('type', '=', 2)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->throw(new FailedLoginException());
        }

        $user->tokens()->delete();

        $user->details = UserDetails::where('user_id', '=', $user->id)->first();
        $token = $user->createToken('resupplify-token')->plainTextToken;
        
        return new AdminLoginResource(['user' => $user, 'token' => $token]);
    }
}
