<?php

namespace App\Services\Company;

use App\Exceptions\Comapny\CompanyNameTaken;
use App\Http\Dto\Company\RegisterCompanyDto;
use App\Models\Company;
use App\Services\BasicService;

class CompanyService extends BasicService
{
    public function createCompany(RegisterCompanyDto $request)
    {
      $company = Company::where('name', '=', $request->name)->first();

    }
}
