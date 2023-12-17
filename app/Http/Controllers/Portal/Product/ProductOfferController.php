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

    /**
     * Show the form for editing the specified product offer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO: Implement edit method logic
    }

    /**
     * Update the specified product offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement update method logic
    }

    /**
     * Remove the specified product offer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: Implement destroy method logic
    }
}
