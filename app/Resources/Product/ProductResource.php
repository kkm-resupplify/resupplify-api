<?php

namespace App\Resources\Product;

use App\Resources\BasicResource;
use App\Resources\Roles\RoleResource;
use App\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'producent' => $this->producent,
            'code' => $this->code,
            'status' => $this->status,
            'verificationStatus' => $this->verification_status,
            'companyId' => $this->company_id,
            'productTypeId' => $this->product_unit_id,
            'productCategory' => [
                'id'=>$this->productSubcategory->productCategory->id,
                'name'=>$this->productSubcategory->productCategory->languages[Auth::user()->language->id-1]->pivot->name,
            ],
            'productSubcategory' => [
                'id'=>$this->productSubcategory->id,
                'name'=>$this->productSubcategory->languages[Auth::user()->language->id-1]->pivot->name,
            ],
        ];
    }
}
