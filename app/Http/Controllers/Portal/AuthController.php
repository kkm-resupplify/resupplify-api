<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller {
  public function __contruct(private readonly AuthService $authService) {
  }

  public function logout(): JsonResponse {
    $this->authService->logout();
  }
}
