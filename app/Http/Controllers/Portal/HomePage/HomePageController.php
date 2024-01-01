<?php

namespace App\Http\Controllers\Portal\HomePage;

use App\Models\Company\Company;
use App\Http\Dto\Order\OrderDto;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Http\Dto\Order\OrderStatusDto;
use App\Resources\Company\CompanyResource;
use App\Services\HomePage\HomePageService;

class HomePageController extends Controller
{

    public function index(HomePageService $service)
    {
        return $this->ok($service->returnPopularProducts());
    }

    public function returnRandomCompanies()
    {
        $companies = Company::inRandomOrder()->take(10)->get();
        return $this->ok(CompanyResource::collection($companies));
    }

}
