<?php

namespace App\Services\Company;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Product\ProductOfferDto;
use Illuminate\Support\Facades\Auth;


class ProductOfferService extends BasicService
{
    use PaginationTrait;
    public function createOffer(ProductOfferDto $request)
    {
    }
}
