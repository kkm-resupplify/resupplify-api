<?php

namespace App\Services\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Exceptions\Company\CompanyNotFoundException;
use App\Exceptions\User\UserAlreadyHaveCompany;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Resources\Company\CompanyCollection;
use App\Resources\Roles\PermissionResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Resources\Company\CompanyResource;
use App\Resources\Roles\PermissionCollection;



class CompanyService extends Controller
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
            'slug' => Str::of($request->name)->snake(),
            'owner_id' => $user->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ];
        // TODO: Add CompanyDetails from the request
        $createdCompany = new Company($company);
        $createdCompany -> owner()->associate($user);
        $createdCompany->save();
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
        $createdCompanyDetails -> company()->associate($createdCompany);
        $createdCompanyDetails->save();
        $role = [
            Role::create(['name' => 'CompanyOwner', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
            Role::create(['name' => 'CompanyAdmin', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
            Role::create(['name' => 'CompanyMember', 'team_id' => $createdCompany->id, 'guard_name' => 'sanctum']),
        ];
        $companyMember = [
            'user_id' => $user->id,
            'company_id' => $createdCompany->id,
            'role_id' => $role[0]->id,
        ];
        $companyMember = new CompanyMember($companyMember);
        $role[0]->givePermissionTo(['view transactions in own company', 'manage own account settings','view products','purchase products','manage users in own company','manage products in own company','view products in own company','add products in own company']);
        setPermissionsTeamId($createdCompany->id);
        $user->assignRole($role[0]);
        $user->save();
        $user->companyMember()->save($companyMember);
        return new CompanyResource($createdCompany);
    }

    public function getCompany(int $companyId)
    {
        return new CompanyResource(Company::with("companyDetails")->findOrFail($companyId));
    }

    public function getCompanies()
    {
        return new CompanyCollection(Company::with("companyDetails")->get());
    }
    public function getUserCompany()
    {
        $user = Auth::user();
        $company = Company::where('owner_id', '=', $user->id)->first();
        if(!isset($company))
        {
            throw new CompanyNotFoundException();
        }
        return new CompanyResource(Company::with("companyDetails")->findOrFail($company->id));
    }

    public function getCompanyRoles()
    {
        return Role::where('team_id', '=', Auth::user()->companyMember->company->id)->get();
    }

    public function getCompanyRolesPermissions()
    {
        return Permission::All();
    }
}
