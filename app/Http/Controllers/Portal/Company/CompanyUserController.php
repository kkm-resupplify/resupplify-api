<?php

namespace App\Http\Controllers\Portal\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Http\Dto\Company\AddUserDto;
use App\Models\Company\Company;
use App\Resources\Company\CompanyUserCollection;
use App\Resources\User\UserResource;
use App\Services\Company\CompanyService;
use App\Services\Company\CompanyUserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyUserController extends Controller
{

    public function addUserToCompany(AddUserDto $request, CompanyUserService $companyUserService): JsonResponse
    {
        return $this->ok($companyUserService->addUserToCompany($request));
    }

    public function getUserCompanyUsers()
    {
        $users = Auth::User()->company::with("users")->with("users.userDetails")->first();
        return $this->ok(new CompanyUserCollection($users->users));
    }
    public function getCompanyUsers(int $id)
    {
        $users = Company::with("users")->findORFail($id)->with("users.userDetails")->first();
        return $this->ok(new CompanyUserCollection($users->users));
    }

    public function deleteUserFromCompany(int $id, int $userId, CompanyUserService $companyUserService): JsonResponse
    {
        return $this->ok($companyUserService->deleteUserFromCompany($id, $userId));
    }

}
