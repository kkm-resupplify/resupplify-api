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
    public function addUserToCompany(
        AddUserDto $request,
        CompanyMemberService $companyMemberService
    ): JsonResponse {
        return $this->ok($companyMemberService->addUserToCompany($request));
    }

    public function getUserCompanyMembers()
    {
        setPermissionsTeamId(Auth::User()->company->id);

        $companyMembers = Auth::user()
            ->company->users()
            ->with('userDetails')
            ->get();

        return $this->ok(new CompanyMemberCollection($companyMembers));
    }

    public function getCompanyMembers(User $user)
    {
        if(isset($user->company))
        {
            setPermissionsTeamId($user->company->id);
        }
        return $this->ok(new UserResource($user));
    }

    public function deleteCompanyMember(
        User $user,
        CompanyMemberService $companyMemberService
    ): JsonResponse {
        return $this->ok($companyMemberService->deleteCompanyMember($user));
    }

    public function leaveCompany(
        CompanyMemberService $companyMemberService
    ): JsonResponse {
        return $this->ok($companyMemberService->leaveCompany());
    }
}
