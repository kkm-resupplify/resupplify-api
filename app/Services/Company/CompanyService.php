<?php

namespace App\Services\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\User\UserAlreadyHaveCompany;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Models\Company\Company;
use App\Models\Company\CompanyBalance;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Resources\Company\CompanyCollection;
use App\Resources\Company\CompanyResource;
use App\Resources\Roles\RoleResource;
use App\Services\BasicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CompanyService extends BasicService
{
    public function createCompany(RegisterCompanyDto $request)
    {
        $user = Auth::user();

        if (Company::where('name', '=', $request->name)->exists()) {
            throw(new CompanyNameTakenException());
        }
        if(isset($user -> companyMember))
        {
            throw(new UserAlreadyHaveCompany());
        }

        $company = [
            'name' => $request->name,
            'short_description' => $request->shortDescription,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'owner_id' => $user->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ];

        $createdCompany = new Company($company);
        $createdCompany -> owner()->associate($user)->save();
        $companyDetails = [
            'country_id' => $request->countryId,
            'address' => $request->address,
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'external_website' => $request->externalWebsite,
            'logo' => $request->logo,
            'company_id' => $createdCompany->id,
            'company_category_id' => $request->companyCategoryId,
            'tin' => $request->tin,
            'contact_person' => $request->contactPerson,
        ];
        $createdCompanyDetails = new CompanyDetails($companyDetails);
        $createdCompany->companyDetails()->save($createdCompanyDetails);
        $companyBalance = new CompanyBalance(['company_id' => $createdCompany->id,'balance' => 0]);
        $createdCompany->companyBalances()->save($companyBalance);
        $role = [
            Role::create(['name' => 'Company owner', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
            Role::create(['name' => 'Company admin', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
            Role::create(['name' => 'Company member', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
        ];
        $companyMember = [
            'user_id' => $user->id,
            'company_id' => $createdCompany->id,
            'role_id' => $role[0]->id,
        ];
        $companyMember = new CompanyMember($companyMember);
        $role[0]->givePermissionTo(['Owner permissions']);
        $role[1]->givePermissionTo(['Admin permissions']);
        $role[2]->givePermissionTo(['CompanyMember permissions']);
        setPermissionsTeamId($createdCompany->id);
        $user->assignRole($role[0]);
        $user->save();
        $user->companyMember()->save($companyMember);
        return new CompanyResource($createdCompany);
    }

    public function getCompany(Company $company)
    {
        return new CompanyResource($company->with("companyDetails")->first());
    }

    public function getCompanies()
    {
        return new CompanyCollection(Company::with("companyDetails")->get());
    }
    public function getUserCompany()
    {
        $company = Auth::user()->company;
        return new CompanyResource(Company::with("companyDetails")->findOrFail($company->id));
    }

    public function getCompanyRoles()
    {
        return RoleResource::collection(Role::where('team_id', '=', Auth::user()->company->id)->get());
    }

    public function getCompanyRolesPermissions()
    {
        return Permission::All();
    }

    public function editCompany(RegisterCompanyDetailsDto $companyDetailsRequest, RegisterCompanyDto $companyRequest, Request $request)
    {

        $user = Auth::user();
        $company = Auth::user()->company;
        $companyDetails = $company->companyDetails;
        if (Company::where('name', '=', $company->name)->where('id', '<>', $company->id)->exists()) {
            throw(new CompanyNameTakenException());
        }
        setPermissionsTeamId($company->id);
        if(!$user->can('Owner permissions'))
        {
            throw(new WrongPermissions());
        }
        $company->update([
            'name' => $companyRequest->name,
            'short_description' => $companyRequest->shortDescription,
            'description' => $companyRequest->description,
            'slug' => Str::slug($companyRequest->name),
            'owner_id' => $user->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ]);

        $companyDetails->update([
            'country_id' => $companyDetailsRequest->countryId,
            'address' => $companyDetailsRequest->address,
            'email' => $companyDetailsRequest->email,
            'phone_number' => $companyDetailsRequest->phoneNumber,
            'external_website' => $companyDetailsRequest->externalWebsite,
            'logo' => $companyDetailsRequest->logo,
            'company_id' => $company->id,
            'company_category_id' => $companyDetailsRequest->companyCategoryId,
            'tin' => $companyDetailsRequest->tin,
            'contact_person' => $request->contactPerson,
        ]);
        return new CompanyResource($company);
    }
}
