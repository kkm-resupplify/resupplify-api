<?php

namespace App\Services\BackOffice\Company;

use App\Http\Controllers\Controller;

use App\Models\Company\Enums\CompanyStatusEnum;

use App\Resources\Company\CompanyCollection;
use App\Resources\Company\CompanyResource;

use App\Models\Company\Company;

class CompanyService extends Controller
{
  public function getCompanies()
  {
    return new CompanyCollection(Company::all());
  }

  public function getUnverifiedCompanies()
  {
  }

  public function getVerifiedCompanies()
  {
  }

  public function verifyCompany()
  {
  }

  public function rejectCompany()
  {
  }
}
