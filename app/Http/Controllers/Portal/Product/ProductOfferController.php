<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductOffer;
use App\Http\Dto\Product\ProductOfferDto;
use App\Services\Product\ProductOfferService;

class ProductOfferController extends Controller
{
    /**
     * Display a listing of the product offers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductOfferService $service)
    {
        // TODO: Implement index method logic
        return $this->ok($service->getOffers());
    }

    /**
     * Store a newly created product offer in storage.
     *
     * @param  \App\Http\Dto\Product\ProductOfferDto  $request
     * @return \Illuminate\Http\Response
     */
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

    public function getCompanyOffers(ProductOfferService $service)
    {
        return $this->ok($service->getCompanyOffers());
    }
}
