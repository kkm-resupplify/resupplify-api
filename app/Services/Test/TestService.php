<?php

namespace App\Services\Test;



use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;


class TestService extends BasicService
{
    public function roleTest()
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // return $user->hasRole('Company owner');
        //return $all_users_with_all_their_roles = User::with('roles')->get();
        //return owner company roles
        //return $user->getPermissionsViaRoles();
        // $role = Role::where('name','Company owner')->first();
        // setPermissionsTeamId($user->company->id);
        //return $role;
        // // $user->assignRole($role);
        //return $user->hasAnyRole('Company owner');
        return $user::with('roles')->with('roles.permissions')->get();
        return $user->roles->first()->permissions;
        // return $user->companyMember->hasRole();
        // if($user->role->hasPermission('CompanyMember permissions'))
        // {
        //     throw new CantCreateUserInvitationException();
        // }
        // $company = app('authUser')->company;
        // $roles = DB::table('roles')->where('team_id', '=', $company->id)->get();
    }
    public function langTest()
    {
        return __('categories.BEVERAGES.SOFT_DRINKS');
    }
}
