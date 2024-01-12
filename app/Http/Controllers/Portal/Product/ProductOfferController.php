<?php

namespace App\Http\Controllers\Portal\Product;

use App\Models\Company\Company;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductOffer;
use App\Http\Dto\Product\ProductOfferDto;
use App\Services\Product\ProductOfferService;
use Illuminate\Http\Request;

class ProductOfferController extends Controller
{
    public function index(Request $request, ProductOfferService $service)
    {
        return $this->ok($service->getOffers($request));
    }

    public function store(ProductOfferDto $request, ProductOfferService $service)
    {
        return $this->ok($service->createOffer($request));
    }

    public function changeStatus(ProductOfferService $service)
    {
        return $this->ok($service->changeStatus());
    }


    public function show($id, ProductOfferService $service)
    {
        return $this->ok($service->getOffer($id));
    }

    public function deactivateOffer($id, ProductOfferService $service)
    {
        $offer = ProductOffer::findOrFail($id);
        return $this->ok($service->deactivateOffer($offer));
    }

    public function possitions(ProductOfferService $service)
    {
        return $this->ok($service->possitions());
    }

    public function getUserCompanyOffers(Request $request, ProductOfferService $service)
    {
        return $this->ok($service->getUserCompanyOffers($request));
    }

    public function getCompanyOffers(Request $request, $slug, ProductOfferService $service)
    {
        $company = Company::where('slug', $slug)
            ->firstOrFail();

        return $this->ok($service->getCompanyOffers($request, $company));
    }
}
