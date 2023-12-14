<?php

namespace App\Http\Controllers\Portal\User;

use App\Http\Controllers\Controller;
use App\Http\Dto\User\UserDetailsDto;
use App\Models\User\User;
use App\Resources\User\UserResource;
use App\Services\User\UserDetailsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function language(Request $request, UserDetailsService $userDetailsService): JsonResponse
    {
        return $this->ok($userDetailsService->changeUserLanguage($request));
    }
}
