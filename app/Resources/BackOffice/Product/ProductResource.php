<?php

namespace App\Resources\BackOffice\Product;

use App\Resources\Product\ProductTagResource;
use App\Resources\Product\ProductUnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $languageId = (app('authUser')->language->id ?? 1) - 1;

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
                'id' => $this->productSubcategory->id,
                'name' => $this->productSubcategory->languages[$languageId]->pivot->name,
            ],
            'productTags' => ProductTagResource::collection($this->productTags),
        ];
    }
}
