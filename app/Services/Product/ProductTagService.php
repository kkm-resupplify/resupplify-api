<?php

namespace App\Services\Product;

use App\Exceptions\Company\WrongPermissions;
use App\Http\Dto\Product\ProductTagDto;
use App\Models\Product\ProductTag;
use App\Resources\Product\ProductTagResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
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

    public function updateProductTag(ProductTagDto $request, ProductTag $productTag)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
        }
        if ($productTag->company_id != Auth::user()->company->id) {
            throw (new WrongPermissions());
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
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
        }
        if ($productTag->company_id != Auth::user()->company->id) {
            throw (new WrongPermissions());
        }
        $productTag->delete();
        return 1;
    }

    public function getProductTag(ProductTag $productTag)
    {
        return $productTag;
    }
}
