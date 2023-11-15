<?php

namespace App\Services\BackOffice\Company;

use App\Exceptions\Company\CompanyNotFoundException;
use App\Exceptions\Company\CompanyAlreadyVerifiedException;

use App\Http\Controllers\Controller;

use App\Models\Company\Enums\CompanyStatusEnum;

use App\Resources\Company\CompanyCollection;

use App\Http\Dto\Company\CompanyMassVerifyDto;

use App\Models\Company\Company;

class CompanyService extends Controller
{
  public function getCompanies()
  {
    return new CompanyCollection(Company::all());
  }

  public function getUnverifiedCompanies()
  {
    return new CompanyCollection(Company::where('status', CompanyStatusEnum::UNVERIFIED())->get());
  }

  public function getVerifiedCompanies()
  {
    return new CompanyCollection(Company::where('status', CompanyStatusEnum::VERIFIED())->get());
  }

  public function verifyCompany($companyId)
  {
    $company = Company::find($companyId);

    if (!isset($company)) {
      throw new CompanyNotFoundException();
    }

    if ($company->status == CompanyStatusEnum::VERIFIED()) {
      throw new CompanyAlreadyVerifiedException();
    }

    $company->status = CompanyStatusEnum::VERIFIED();
    $company->save();

    return $company;
  }

  public function rejectCompany($companyId)
  {
    $company = Company::find($companyId);

    if (!isset($company)) {
      throw new CompanyNotFoundException();
    }

    $company->status = CompanyStatusEnum::REJECTED();
    $company->save();

    return $company;
  }

  public function massStatusUpdate(CompanyMassVerifyDto $statusUpdateDTO)
  {
    Company::whereIn('id', $statusUpdateDTO->companyIds)->update(['status' => $statusUpdateDTO->newStatus]);

    return ['status' => $statusUpdateDTO->newStatus];
  }
}
