<?php

namespace App\Services\Company;

use App\Exceptions\Company\CantDeleteThisUserException;
use App\Exceptions\Company\CantDeleteYourself;
use App\Exceptions\Company\CompanyNameTakenException;
use App\Exceptions\Company\CompanyNotFoundException;
use App\Exceptions\Company\UserInviteCodeNotFoundException;
use App\Exceptions\Company\UserInviteCodeUsedException;
use App\Exceptions\RoleNotFoundException;
use App\Exceptions\User\UserAlreadyHaveCompany;
use App\Http\Dto\Company\AddUserDto;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Models\Company\UserInvitationCode;
use App\Models\User\User;
use App\Resources\Company\CompanyCollection;
use App\Resources\Roles\PermissionResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Resources\Company\CompanyResource;
use App\Resources\Roles\PermissionCollection;


class CompanyUserService extends Controller
{
    public function addUserToCompany(AddUserDto $request)
    {
        $invitationCode = UserInvitationCode::where('invitationCode','=',$request->invitationCode)->first();
        if(!isset($invitationCode))
        {
            throw new UserInviteCodeNotFoundException();
        }
        if($invitationCode['is_used'] == 1)
        {
            throw new UserInviteCodeUsedException();
        }
        $user = Auth::user();
        if(isset($user->companyMember))
        {
            throw new UserAlreadyHaveCompany();
        }
        $company = $invitationCode->company;
        $roles = DB::table('roles')->where('team_id', '=', $company->id)->get();
        if (in_array($invitationCode->role_id, $roles->pluck('id')->toArray())) {
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
    public function deleteUserFromCompany(User $user)
    {

        $company = $user->company;
        $loggedUser = Auth::user();
        if(!isset($company))
        {
            throw new CompanyNotFoundException();
        }
        setPermissionsTeamId($company->id);
        if($loggedUser->id == $user->id)
        {
            throw new CantDeleteYourself();
        }
        if($user->can('Owner permissions') || ($user->can('Admin permissions') && !$loggedUser->can('Owner permissions') || $loggedUser->can('User permissions')) || $loggedUser->id == $user->id)
        {
            throw new CantDeleteThisUserException();
        }
        $user->delete();
        return 1;
    }

}
