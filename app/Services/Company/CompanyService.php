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
use Illuminate\Http\Request;
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
            'slug' => Str::slug($request->name),
            'owner_id' => $user->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ];
        // TODO: Add CompanyDetails from the request
        $createdCompany = new Company($company);
        $createdCompany->save();
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
        // $createdCompanyDetails -> company()->associate($createdCompany);
        // $createdCompanyDetails->save();
        $createdCompany->companyDetails()->save($createdCompanyDetails);
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
        $role[2]->givePermissionTo(['User permissions']);
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
        return Role::where('team_id', '=', Auth::user()->companyMember->company->id)->get();
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
        $company->name = $companyRequest->name;
        $company->short_description = $companyRequest->shortDescription;
        $company->description = $companyRequest->description;
        $company->slug = Str::slug($companyRequest->name);
        $company->owner_id = $user->id;
        $company->status = CompanyStatusEnum::UNVERIFIED();
        $company->save();
        $companyDetails->country_id = $companyDetailsRequest->countryId;
        $companyDetails->address = $companyDetailsRequest->address;
        $companyDetails->email = $companyDetailsRequest->email;
        $companyDetails->phone_number = $companyDetailsRequest->phoneNumber;
        $companyDetails->external_website = $companyDetailsRequest->externalWebsite;
        $companyDetails->logo = $companyDetailsRequest->logo;
        $companyDetails->company_id = $company->id;
        $companyDetails->company_category_id = $companyDetailsRequest->companyCategoryId;
        $companyDetails->tin = $companyDetailsRequest->tin;
        $companyDetails->contact_person = $request->contactPerson;
        $companyDetails->save();
        return new CompanyResource($company);
    }
}
