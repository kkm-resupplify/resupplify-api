<?php

namespace App\Services\Company;

use App\Exceptions\Company\CantCreateUserInvitationException;
use App\Exceptions\Company\CantCreateUserInvitationRoleException;
use App\Exceptions\Company\CompanyNameTakenException;
use App\Exceptions\RoleNotFoundException;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Http\Dto\Company\UserInvitationCodes;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Models\Company\UserInvitationCode;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;


class InvitationService extends Controller
{
    //TODO: Sprawdzenie czy user ma uprawnienia żeby stworzyć zaproszenie
    public function createUserInvitation(UserInvitationCodes $request)
    {
        $user = Auth::user();
        return $user->companyMember->hasRole();
        if($user->role->hasPermission('User permissions'))
        {
            throw new CantCreateUserInvitationException();
        }
        $company = Auth::user()->company;
        $roles = DB::table('roles')->where('team_id', '=', $company->id)->get();
        if (in_array($request->roleId, $roles->pluck('id')->toArray())) {
            $role = Role::find($request->roleId);
            if($role->hasPermission('Owner permissions'))
            {
                throw new CantCreateUserInvitationRoleException();
            }
            $invitationData = [
                'company_id' => $company->id,
                'role_id' => $request->roleId,
                'invitationCode' => Uuid::uuid4()->toString(),
            ];
            $invitation = new UserInvitationCode($invitationData);
            $company->invitationCodes()->save($invitation);

            return response()->json(['invitationCode' => $invitation['invitationCode']]);

        } else {
            throw new RoleNotFoundException();
        }
    }
}
