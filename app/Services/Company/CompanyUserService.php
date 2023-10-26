<?php

namespace App\Services\Company;

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
        //return UserInvitationCode::all();
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
            return new CompanyResource($company);
        } else {
            throw new RoleNotFoundException();
        }
    }

    //soft delete
    public function deleteUserFromCompany(int $id, int $userId)
    {
        $company = Company::find($id);
        if(!$company->exists())
        {
            throw new CompanyNotFoundException();
        }
        $userToDelete = User::find($userId);
        if(!$userToDelete->exists())
        {
            //todo: throw user to delete not found exception
            throw new CompanyNotFoundException();
        }
        $companyMember = CompanyMember::where('user_id', '=', $userId)->where('company_id', '=', $id)->first();
        if(!$companyMember->exists())
        {
            //todo: throw user is not member of company exception
            throw new CompanyNotFoundException();
        }
        if(Auth()->user()->id == $userToDelete->id)
        {
            //todo: throw cannot delete yourself exception
            throw new CompanyNotFoundException();
        }

        $companyMember->delete();
        return new CompanyResource($company);
    }

}
