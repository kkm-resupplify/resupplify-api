<?php

namespace App\Services\BackOffice\Company;

use App\Exceptions\Company\CompanyAlreadyVerifiedException;
use App\Exceptions\Company\CompanyNotFoundException;
use App\Http\Dto\Company\CompanyMassVerifyDto;
use App\Models\Company\Company;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Resources\Company\CompanyCollection;
use App\Services\BasicService;

class CompanyService extends BasicService
{
  public function getCompanies()
  {
    return new CompanyCollection(Company::all());
  }

  public function getUnverifiedCompanies()
  {
    return new CompanyCollection(Company::whereIn('status', [
      CompanyStatusEnum::UNVERIFIED(), CompanyStatusEnum::REJECTED()
    ])->get());
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
