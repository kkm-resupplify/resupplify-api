<?php

namespace App\Http\Controllers\Portal\User;

use App\Http\Requests\UserDetailsRequest;
use App\Models\User\User;
use App\Services\User\UserDetailsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Dto\User\UserDetailsDto;
use App\Http\Controllers\Controller;
use App\Resources\User\UserLoginResource;
use App\Resources\User\UserResource;
use Laravel\Sanctum\PersonalAccessToken;

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

    public function index()
    {
        return $this->ok(new UserResource(User::with('userDetails')->findOrFail(Auth::User()->id)));
    }
}
