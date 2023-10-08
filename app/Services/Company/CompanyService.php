<?php

namespace App\Services\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Http\Dto\Company\RegisterCompanyDetailsDto;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetails;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Http\Controllers\Controller;

class CompanyService extends Controller
{
    public function createCompany(RegisterCompanyDto $request)
    {
        if (Company::where('name', '=', $request->name)->exists()) {
            throw(new CompanyNameTakenException());
        }

        $company = [
            'name' => $request->name,
            'short_description' => $request->shortDescription,
            'description' => $request->description,
            'slug' => Str::of($request->name)->snake(),
            'owner_id' => Auth::user()->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ];
        // TODO: Add CompanyDetails from the request
        return Company::create($company);
    }

    public function addBasicRolesToCompany()
    {
        $newRole = CompanyRole::create([
            'name' => 'Admin',
            'permission_level' => [''],
            'company_id' => $companyId,
        ]);
    }
    public function addOwnerToCompany()
    {
        CompanyMember::create([
            'user_id' => Auth::user()->id,
            'company_id' => $companyId,
            'company_role_id' => $roleId,
            'roles' => $role
        ]);
    }

    public function createCompanyDetails(RegisterCompanyDetailsDto $request)
    {
        // if(!isset(Auth::user()->companyMember->company->id))
        // {
        //     throw(new CompanyNameTakenException());
        // }

        $companyDetails = [
            'country_id' => $request->countryId,
            'address' => $request->address,
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'external_website' => $request->externalWebsite,
            'logo' => $request->logo,
            'company_id' => Auth::user()->companyMember()->company->id,
            'company_category_id' => $request->companyCategoryId,
            'tin' => $request->tin,
        ];
        return CompanyDetails::create($companyDetails);
    }

    public
}
