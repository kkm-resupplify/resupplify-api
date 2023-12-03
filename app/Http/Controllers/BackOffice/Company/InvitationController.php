<?php

namespace App\Http\Controllers\BackOffice\Company;

use App\Http\Controllers\Controller;
use App\Http\Dto\Company\UserInvitationCodes;
use App\Services\Company\InvitationService;
use Illuminate\Http\JsonResponse;

class InvitationController extends Controller
{
    public function createInvitationCode(UserInvitationCodes $requestr, InvitationService $invitationService): JsonResponse
    {
        return $this->ok($invitationService->createUserInvitation($requestr));
    }
}
