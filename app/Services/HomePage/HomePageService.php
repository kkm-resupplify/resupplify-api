<?php

namespace App\Services\HomePage;


use App\Models\Order\Order;
use App\Services\BasicService;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Helpers\PaginationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Resources\HomePage\HomePageCompanyResource;
use App\Resources\HomePage\HomePageProductResource;
use App\Models\Product\Enums\ProductOfferStatusEnum;


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

        $products = $query->get();

        if ($products->count() < 10) {
            $missingProductsCount = 10 - $products->count();
            $missingProducts = Product::inRandomOrder()->take($missingProductsCount)->get();
            $products = $products->concat($missingProducts);
        }

        return HomePageProductResource::collection($products);
    }

    public function returnCompanies()
    {
        $companies = Company::inRandomOrder()->take(10)->get();
        foreach ($companies as $company) {
            $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
                ->join('product_offers', 'product_warehouse.id', '=', 'product_offers.company_product_id')
                ->join('order_product_offer', 'product_offers.id', '=', 'order_product_offer.product_offer_id')
                ->where('product_offers.company_id', $company->id);
            $query->select('products.*', DB::raw('SUM(order_product_offer.offer_quantity) as total_quantity'));
            $query->groupBy('products.id');
            $company->productsSold = $query->get()->sum(function ($product) {
                return $product->total_quantity;
            });
            $uniqueClients = Order::where('seller_id', $company->id)->distinct('buyer_id')->pluck('buyer_id');
            $company->uniqueClientsCount = $uniqueClients->count();
            $company->offersActive = $company->productOffers()->where('product_offers.status', ProductOfferStatusEnum::ACTIVE())->count();
        }

        return HomePageCompanyResource::collection($companies);
    }
}
