<?php

namespace App\Services\Company;

use App\Exceptions\Company\CompanyNameTakenException;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Models\Company\Company;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company\Enums\CompanyStatusEnum;

class CompanyService extends BasicService
{
    public function createCompany(RegisterCompanyDto $request)
    {
        if (Company::where('name', '=', $request->name)->exists()) {
            $this->throw(new CompanyNameTakenException());
        }

        $company = [
            'name' => $request->name,
            'short_description' => $request->shortDescription,
            'description' => $request->description,
            'country_id' => $request->countryId,
            'slug' => Str::of($request->name)->snake(),
            'owner_id' => Auth::user()->id,
            'status' => CompanyStatusEnum::UNVERIFIED(),
        ];
        // TODO: Add CompanyDetails from the request
        return Company::create($company);
    }
}
