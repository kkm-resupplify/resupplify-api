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
    public function createInvitationCode(UserInvitationCodes $requestr, InvitationService $invitationService): JsonResponse
    {
        return $this->ok([$invitationService->createUserInvitation($requestr)]);
    }
}
