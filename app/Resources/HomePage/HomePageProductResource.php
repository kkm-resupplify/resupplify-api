<?php

namespace App\Resources\HomePage;


use App\Models\Company\Company;
use App\Models\Product\ProductOffer;
use Illuminate\Support\Facades\Auth;
use App\Resources\Product\ProductTagResource;
use App\Resources\Product\ProductUnitResource;
use App\Resources\Product\ProductOfferResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Product\ProductTranslationResource;

class HomePageProductResource extends JsonResource
{
    public function toArray($request)
    {
        $languageId = (app('authUser')->language->id ?? 1) - 1;
        $id = $this->id;

        $productOffer = ProductOffer::whereHas('productWarehouse', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get()->sortByDesc(function ($productOffer) {
            return $productOffer->product_quantity;
        })->first();

        $company = Company::find($this->company_id);
        return [
            'id' => $this->id,
            'name' => $this->languages[$languageId]->pivot->name,
            'description' => $this->languages[$languageId]->pivot->description,
            'companyName' => $company->name,
            'productUnit' => new ProductUnitResource($this->productUnit),
            'productCategory' => [
                'id' => $this->productSubcategory->productCategory->id,
                'name' => $this->productSubcategory->productCategory->languages[$languageId]->pivot->name,
            ],
            'productSubcategory' => [
                'categoryId' => $this->productSubcategory->product_category_id,
                'id' => $this->productSubcategory->id,
                'name' => $this->productSubcategory->languages[$languageId]->pivot->name,
            ],
            'image' => $this->image,
            'productTags' => ProductTagResource::collection($this->productTags),
            'translations' => ProductTranslationResource::collection($this->languages),
            'soldQuantity' => (int) $this->total_quantity,
            'productOffer' => new ProductOfferResource($productOffer),
        ];
    }
}
