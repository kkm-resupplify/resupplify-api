<?php

namespace App\Http\Controllers\Portal\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Http\Dto\Company\AddUserDto;
use App\Models\Company\Company;
use App\Models\User\User;
use App\Resources\Company\CompanyMemberCollection;
use App\Resources\User\UserResource;
use App\Services\Company\CompanyService;
use App\Services\Company\CompanyMemberService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyMemberController extends Controller
{

    public function addUserToCompany(AddUserDto $request, CompanyMemberService $companyMemberService): JsonResponse
    {
        return $this->ok($companyMemberService->addUserToCompany($request));
    }

    public function getUserCompanyMembers()
    {
        setPermissionsTeamId(Auth::User()->company->id);
        $users = Auth::User()->company::with("users")->with("users.userDetails")->with("users.roles")->first();
        return $this->ok(new CompanyMemberCollection($users->users));
    }
    public function getCompanyMembers(int $id)
    {
        setPermissionsTeamId(Auth::User()->company->id);
        $users = Company::with("users")->findORFail($id)->with("users.userDetails")->with("users.roles")->first();
        return $this->ok(new CompanyMemberCollection($users->users));
    }

    public function deleteCompanyMember(User $user, CompanyMemberService $companyMemberService): JsonResponse
    {
        return $this->ok($companyMemberService->deleteCompanyMember($user));
    }

    public function leaveCompany(CompanyMemberService $companyMemberService): JsonResponse
    {
        return $this->ok($companyMemberService->leaveCompany());
    }

}
