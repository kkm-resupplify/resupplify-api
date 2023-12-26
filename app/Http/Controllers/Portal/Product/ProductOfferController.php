<?php

namespace App\Http\Controllers\Portal\Product;

use App\Models\Company\Company;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductOffer;
use App\Http\Dto\Product\ProductOfferDto;
use App\Services\Product\ProductOfferService;

class ProductOfferController extends Controller
{
    public function index(ProductOfferService $service)
    {
        return $this->ok($service->getOffers());
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
        $offer = ProductOffer::findOrFail($id);
        return $this->ok($service->getOffer($offer));
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

    public function getUserCompanyOffers(ProductOfferService $service)
    {
        return $this->ok($service->getUserCompanyOffers());
    }

    public function getCompanyOffers($slugOrId, ProductOfferService $service)
    {
        $company = Company::where('id', $slugOrId)
            ->orWhere('slug', $slugOrId)
            ->firstOrFail();
        return $this->ok($service->getCompanyOffers($company));
    }
}
