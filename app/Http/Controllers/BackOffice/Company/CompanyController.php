<?php

namespace App\Http\Controllers\BackOffice\Company;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Models\Company\Company;

use App\Services\BackOffice\Company\CompanyService;

class CompanyController extends Controller
{
  public function index(CompanyService $companyService): JsonResponse
  {
    return $this->ok($companyService->getCompanies());
  }
}
