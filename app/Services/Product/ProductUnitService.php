<?php

namespace App\Services\Product;

use App\Services\BasicService;
use Illuminate\Support\Facades\DB;


class ProductUnitService extends BasicService
{
    public function getProductUnits()
    {
        return DB::table('product_units')->get();
    }
}
