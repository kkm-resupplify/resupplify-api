<?php

namespace App\Resources\Product;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Product\ProductTranslationResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $languageId = app('authUser')->language->id - 1;
        return [
            'id' => $this->id,
            'name' => $this->languages[$languageId]->pivot->name,
            'description' => $this->languages[$languageId]->pivot->description,
            'producer' => $this->producer,
            'code' => $this->code,
            'status' => $this->status,
            'verificationStatus' => $this->verification_status,
            'companyId' => $this->company_id,
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
            'imageAlt' => $this->image_alt,
            'productTags' => ProductTagResource::collection($this->productTags),
            'translations' => ProductTranslationResource::collection($this->languages),
        ];
    }
}
