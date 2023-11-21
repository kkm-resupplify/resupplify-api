<?php

namespace App\Services\Company;


use App\Models\Company\CompanyCategory;
use App\Services\BasicService;
use Illuminate\Support\Str;

class CompanyCategoryService extends BasicService
{
    public function getCategories()
    {
        return CompanyCategory::all();
    }
}
