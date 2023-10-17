<?php

namespace App\Http\Controllers\Portal\User;

use App\Http\Requests\UserDetailsRequest;
use App\Models\UserDetails;
use App\Services\User\UserDetailsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Dto\User\UserDetailsDto;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function createUserDetails(UserDetailsDto $request, UserDetailsService $userDetailsService): JsonResponse
    {
        return $this->ok($userDetailsService->creatUserData($request));
    }

    public function editUserDetails(UserDetailsDto $request, UserDetailsService $userDetailsService): JsonResponse
    {
        return $this->ok($userDetailsService->editUserData($request));
    }
}
