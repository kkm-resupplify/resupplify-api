<?php

namespace App\Services\Company;

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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Ramsey\Uuid\Uuid;


class InvitationService extends Controller
{
    //TODO: Sprawdzenie czy user ma uprawnienia żeby stworzyć zaproszenie
    public function createUserInvitation(UserInvitationCodes $request)
    {
        $user = Auth::user();
        $company = $user->companyMember->company;
        //get roles from company
        $roles = DB::table('roles')->where('team_id', '=', $company->id)->get();

        //check if $request->roleId is in roles array
        if (in_array($request->roleId, $roles->pluck('id')->toArray())) {
            $invitationData = [
                'company_id' => $company->id,
                'role_id' => $request->roleId,
                'code' => Uuid::uuid4()->toString(),
            ];
            $invitation = new UserInvitationCode($invitationData);
            $invitation->company()->associate($company);
            $invitation->save();


            return ['invitation'=> $invitation];
        } else {
            throw new RoleNotFoundException();
        }
    }
}
