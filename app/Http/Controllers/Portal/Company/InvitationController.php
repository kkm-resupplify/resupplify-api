<?php

namespace App\Http\Controllers\Portal\Company;

use App\Http\Dto\Company\UserInvitationCodes;
use App\Services\Company\CompanyService;
use App\Services\Company\InvitationService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;

class InvitationController extends Controller
{
    public function store(RegisterCompanyDto $request, CompanyService $companyService): JsonResponse
    {
        return $this->ok([$companyService->createCompany($request)]);
    }

    public function createCompanyDetails(RegisterCompanyDetailsDto $requestr, CompanyService $companyService): JsonResponse
    {
        return $this->ok([$companyService->createCompanyDetails($requestr)]);
    }

    public function createInvitationCode(UserInvitationCodes $requestr, InvitationService $invitationService): JsonResponse
    {
        return $this->ok([$invitationService->createUserInvitation($requestr)]);
    }
}
