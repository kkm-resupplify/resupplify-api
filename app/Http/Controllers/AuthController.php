<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Dto\User\LoginDto;
use App\Http\Dto\User\PortalRegisterDto;

class AuthController extends Controller
{
    public function login(
        LoginDto $request,
        AuthService $authService
    ): JsonResponse {
        return $this->OK($authService->login($request));
    }

    public function register(
        PortalRegisterDto $request,
        AuthService $authService
    ): JsonResponse {
        return $this->OK($authService->portalRegister($request));
    }

    public function logout(Request $request)
    {
    }
}
