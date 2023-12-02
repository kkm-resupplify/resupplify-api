<?php

namespace App\Services\Company;

use App\Exceptions\Company\CantDeleteThisUserException;
use App\Exceptions\Company\CantDeleteYourself;
use App\Exceptions\Company\CompanyNotFoundException;
use App\Exceptions\Company\UserInviteCodeNotFoundException;
use App\Exceptions\Company\UserInviteCodeUsedException;
use App\Exceptions\Role\RoleNotFoundException;
use App\Exceptions\User\UserAlreadyHaveCompany;
use App\Http\Dto\Company\AddUserDto;
use App\Models\Company\CompanyMember;
use App\Models\Company\UserInvitationCode;
use App\Models\User\User;
use App\Resources\Company\CompanyResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CompanyMemberService extends BasicService
{
    public function addUserToCompany(AddUserDto $request)
    {
        $invitationCode = UserInvitationCode::where(
            'invitationCode',
            '=',
            $request->invitationCode
        )->first();
        if (!isset($invitationCode)) {
            throw new UserInviteCodeNotFoundException();
        }
        if ($invitationCode['is_used'] == 1) {
            throw new UserInviteCodeUsedException();
        }
        $user = Auth::user();
        if (isset($user->companyMember)) {
            throw new UserAlreadyHaveCompany();
        }
        $company = $invitationCode->company;
        $roles = DB::table('roles')
            ->where('team_id', '=', $company->id)
            ->get();
        if (
            in_array($invitationCode->role_id, $roles->pluck('id')->toArray())
        ) {
            $companyMember = [
                'user_id' => $user->id,
                'company_id' => $company->id,
                'role_id' => $invitationCode->role_id,
            ];
            $companyMember = new CompanyMember($companyMember);
            setPermissionsTeamId($company->id);
            $user->assignRole(Role::findOrFail($invitationCode->role_id));

            $user->companyMember()->save($companyMember);
            $invitationCode['is_used'] = 1;
            $invitationCode->save();
            //todo: add role assigned to user to the companyResource
            return new CompanyResource($company);
        } else {
            throw new RoleNotFoundException();
        }
    }

    //soft delete
    public function deleteCompanyMember(User $user)
    {
        $company = $user->company;
        $loggedUser = Auth::user();

        if (!isset($company)) {
            throw new CompanyNotFoundException();
        }
        setPermissionsTeamId($company->id);

        if ($loggedUser->id == $user->id) {
            throw new CantDeleteYourself();
        }

        if (
            $user->can('Owner permissions') ||
            (($user->can('Admin permissions') &&
                !$loggedUser->can('Owner permissions')) ||
                $loggedUser->can('CompanyMember permissions')) ||
            $loggedUser->id == $user->id
        ) {
            throw new CantDeleteThisUserException();
        }

        $user->companyMember->delete();
        return 1;
    }

    public function leaveCompany()
    {
        $user = Auth::user();
        $company = $user->company;
        if (!isset($company)) {
            throw new CompanyNotFoundException();
        }
        setPermissionsTeamId($company->id);
        if ($user->can('Owner permissions')){
            throw new CantDeleteThisUserException();
        }
        $user->roles()->detach();
        $user->companyMember()->delete();
        return 1;
    }
}
