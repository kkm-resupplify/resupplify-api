<?php

namespace App\Services\Product;
use App\Resources\Product\ProductCategoryAndSubcategoryResource;
use App\Resources\Product\ProductCategoryResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Company\WrongPermissions;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductTag;
use App\Http\Dto\Product\ProductTagDto;
use Illuminate\Support\Str;
use App\Resources\Product\ProductTagResource;
class ProductTagService extends BasicService
{
    public function getProductTags()
    {
        return ProductTagResource::collection(Auth::user()->company->productTags);
    }

    public function createProductTag(ProductTagDto $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $tagData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color,
            'company_id' => Auth::user()->company->id,
        ];
        $tag = ProductTag::create($tagData);
        return $tag;
    }

    public function updateProductTag(ProductTagDto $request,ProductTag $productTag)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        if ($productTag->company_id!= Auth::user()->company->id)
        {
            throw(new WrongPermissions());
        }
        $productTag->name = $request->name;
        $productTag->slug = STR::slug($request->name);
        $productTag->color = $request->color;
        $productTag->save();
        return $productTag;
    }
    public function deleteProductTag(ProductTag $productTag)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        if ($productTag->company_id!= Auth::user()->company->id)
        {
            throw(new WrongPermissions());
        }
        $productTag->delete();
        return 1;
    }

    public function getProductTag(ProductTag $productTag)
    {
        return $productTag;
    }

}
