<?php

namespace App\Services\Company;

use App\Exceptions\Company\CantCreateUserInvitationRoleException;
use App\Exceptions\Role\RoleNotFoundException;
use App\Http\Dto\Company\UserInvitationCodes;
use App\Models\Company\UserInvitationCode;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;


class InvitationService extends BasicService
{
    //TODO: Sprawdzenie czy user ma uprawnienia żeby stworzyć zaproszenie
    public function createUserInvitation(UserInvitationCodes $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        $company = Auth::user()->company;
        $roles = DB::table('roles')->where('team_id', '=', $company->id)->get();
        if (in_array($request->roleId, $roles->pluck('id')->toArray())) {
            $role = Role::find($request->roleId);
            if ($role->hasPermissionTo('Owner permissions') || ($role->hasPermissionTo('Admin permissions') && !$user->can('Owner permissions') || $user->can('CompanyMember permissions'))) {
                throw new CantCreateUserInvitationRoleException();
            }
            $invitationData = [
                'company_id' => $company->id,
                'role_id' => $request->roleId,
                'invitationCode' => Uuid::uuid4()->toString(),
            ];
            $invitation = new UserInvitationCode($invitationData);
            $company->invitationCodes()->save($invitation);

            return ['invitationCode' => $invitation['invitationCode']];
        } else {
            throw new RoleNotFoundException();
        }
    }
}
