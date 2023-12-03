<?php

namespace App\Http\Controllers\BackOffice\Company;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyCategoryService;

class CompanyCategoryController extends Controller
{

    public function index(CompanyCategoryService $companyCategory)
    {
        return $this->ok($companyCategory->getCategories());
    }

    public function unverifiedCompanies(CompanyCategoryService $companyCategory)
    {
        return $this->ok($companyCategory->getUnverifiedCompanies());
    }
}
