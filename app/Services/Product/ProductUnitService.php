<?php

namespace App\Services\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ProductUnitService extends Controller
{
    public function getProductUnits()
    {
        return DB::table('product_units')->get();
    }
}
