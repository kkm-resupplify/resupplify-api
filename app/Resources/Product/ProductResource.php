<?php

namespace App\Resources\Product;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $languageId = Auth::user()->language->id - 1;

        return [
            'id' => $this->id,
            'name' => $this->languages[$languageId]->pivot->name,
            'description' => $this->languages[$languageId]->pivot->description,
            'producent' => $this->producent,
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
            'productTags' => ProductProductTagResource::collection($this->productTags),
        ];
    }
}
