<?php

namespace App\Services\Product;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService extends Controller
{
    public function createProduct(ProductDto $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $productData = [
            'producent' => $request->producent,
            'code' => $request->code,
            'product_unit_id' => $request->productUnitId,
            'product_subcategory_id' => $request->productSubcategoryId,
            'company_id' => $user->company->id,
            'status' => ProductStatusEnum::INACTIVE(),
            'verification_status' => ProductVerificationStatusEnum::UNVERIFIED(),
        ];

        $product = new Product($productData);
        $user->company->products()->save($product);
        foreach ($request->name as $key => $value) {
            $product->languages()->attach($key, ['name' => $value, 'description' => $request->description[$key]]);
        }
        return new ProductResource($product);
    }
    public function deleteProduct(Product $product)
    {
        $user = Auth::user();
        $company = $user->company->products;
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        if (!$company->contains($product))
        {
            throw(new ProductNotFoundException());
        }
        $product->delete();
        return 1;
    }
    public function getProduct(Product $product)
    {
        return new ProductResource($product);
    }
    public function getProducts()
    {
        $user = Auth::user();
        $products = $user->company->products()->paginate(config('paginationConfig.PRODUCTS_PER_PAGE'));
        $pagination = [
            'pagination'=>[
            'currentPage' => $products->currentPage(),
            'totalPages' => $products->lastPage(),
            'perPage' => $products->perPage(),
            'countRecords' => $products->count(),
            'totalRecords' => $products->total(),
            ]
        ];
        return array_merge($pagination, ['products' => ProductResource::collection($products)]);
    }

    public function editProduct(ProductDto $request, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $productData = [
            'producent' => $request->producent,
            'code' => $request->code,
            'product_unit_id' => $request->productUnitId,
            'product_subcategory_id' => $request->productSubcategoryId,
            'company_id' => $user->company->id,
            'status' => ProductStatusEnum::INACTIVE(),
            'verification_status' => ProductVerificationStatusEnum::UNVERIFIED(),
        ];
        $product->update($productData);
        foreach ($request->name as $key => $value) {
            $product->languages()->updateExistingPivot([$product->id,$key],[
                'name' => $request->name[$key],
                'description' => $request->description[$key],
            ]);
        }
        return new ProductResource($product);
    }

    public function massAssignProductStatus(Request $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        $companyProducts = $user->company->products;
        $requestProducts = $request->productIdList;
        $status = $request->status;
        foreach ($requestProducts as $productId)
        {
            if (!$companyProducts->contains('id', $productId))
            {
                throw(new ProductNotFoundException());
            }
            $product = Product::findOrFail($productId);
            $product->update(['status' => $status]);
        }
        return 1;
    }
}
