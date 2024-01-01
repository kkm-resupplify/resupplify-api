<?php

namespace App\Services\HomePage;


use App\Services\BasicService;
use App\Models\Product\Product;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Resources\HomePage\HomePageProductResource;


class HomePageService extends BasicService
{
    use PaginationTrait;

    public function returnPopularProducts()
    {
        $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
                ->join('product_offers', 'product_warehouse.id', '=', 'product_offers.company_product_id')
                ->join('order_product_offer', 'product_offers.id', '=', 'order_product_offer.product_offer_id');
        $query->select('products.*', DB::raw('SUM(order_product_offer.offer_quantity) as total_quantity'));
        $query->groupBy('products.id');
        $query->orderBy('total_quantity', 'desc')->take(10);
        return HomePageProductResource::collection($query->get());
    }
}
