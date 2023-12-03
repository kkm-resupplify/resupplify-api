<?php

namespace App\Http\Controllers;

use App\Http\Dto\User\BackOfficeRegisterDto;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

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
        Auth()
            ->user()
            ->currentAccessToken()
            ->delete();
        return $this->ok();
    }

    public function backOfficeRegister(
        BackOfficeRegisterDto $request,
        AuthService $authSerice
    ): JsonResponse {
        return $this->ok($authSerice->backOfficeRegister($request));
    }

    public function backOfficeLogin(
        LoginDto $request,
        AuthService $authService
    ): JsonResponse {
        return $this->ok($authService->backOfficeLogin($request));
    }
}
