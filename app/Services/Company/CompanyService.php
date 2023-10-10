<?php

namespace App\Services\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class CompanyService extends Controller
{
    public function createCompany(RegisterCompanyDto $request)
    {
        $user = Auth::user();

        if (Company::where('name', '=', $request->name)->exists()) {
            throw(new CompanyNameTakenException());
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
        $createdCompany = Company::create($company);
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
        ];
        $createdCompany = CompanyDetails::create($companyDetails);
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
        CompanyMember::create($companyMember);
        $role[0]->givePermissionTo(['view transactions in own company', 'manage own account settings','view products','purchase products','manage users in own company','manage products in own company','view products in own company','add products in own company']);
        setPermissionsTeamId($createdCompany->id);
        $user->assignRole($role[0]);
        $user->save();
        return $createdCompany;
    }
}
