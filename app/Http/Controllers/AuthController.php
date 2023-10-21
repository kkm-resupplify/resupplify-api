<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;

class AuthController extends Controller
{

    public function login(
        LoginDto $request,
        AuthService $authService
    ): JsonResponse {
        return $this->ok($authService->login($request));
    }

    public function register(
        PortalRegisterDto $request,
        AuthService $authService
    ): JsonResponse {
        return $this->ok($authService->portalRegister($request));
    }

    public function logout()
    {
        Auth()->user()->currentAccessToken()->delete();
        return $this->ok();
    }
}
