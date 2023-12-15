<?php

namespace App\Services\Company;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Product\OfferDto;
use Illuminate\Support\Facades\Auth;


class OfferService extends BasicService
{
    use PaginationTrait;
    public function createOffer(OfferDto $request)
    {
    }
}
