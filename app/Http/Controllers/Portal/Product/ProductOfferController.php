<?php

namespace App\Http\Controllers\Portal\Product;

use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductOfferDto;
use App\Services\Company\ProductOfferService;
use Illuminate\Http\Request;

class ProductOfferController extends Controller
{
    /**
     * Display a listing of the product offers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Implement index method logic
    }

    /**
     * Store a newly created product offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductOfferDto $request, ProductOfferService $service)
    {
        return $this->ok($service->createOffer($request));
    }

    /**
     * Display the specified product offer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO: Implement show method logic
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
