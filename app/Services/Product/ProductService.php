<?php

namespace App\Services\Product;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductTagDontBelongToThisCompanyException;
use App\Exceptions\Product\ProductTranslationException;
use App\Filters\Product\ProductCategoryFilter;
use App\Filters\Product\ProductNameFilter;
use App\Helpers\PaginationTrait;
use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use App\Models\Product\Product;
use App\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Language\Language;
class ProductService extends Controller
{
    use PaginationTrait;

    public function createProduct(ProductDto $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
        }
        $languages = Language::all();
        foreach ($request->translations as $language)
        {
            $translationId = $language['languageId'];
            if($languages->contains($translationId))
            {
                throw new ProductTranslationException();
            }
        }
        if($request->translations < Count(Language::all()))
        {
            throw (new ProductTranslationException());
        }
        $productData = [
            'producent' => $request->producent,
            'code' => $request->code,
            'product_unit_id' => $request->productUnitId,
            'product_subcategory_id' => $request->productSubcategoryId,
            'company_id' => $user->company->id,
            'status' => ProductStatusEnum::INACTIVE(),
            'verification_status' => ProductVerificationStatusEnum::UNVERIFIED(),
            'product_tags_id' => $request->productTagsId,
        ];
        $productTags = $user->company->load('productTags')->productTags;
        $invalidTags = "";
        $productTagsId = Arr::get($productData, 'product_tags_id', []);
        if ($productData['product_tags_id'] !== null) {
        foreach ($productTagsId as $productTagsId)
        {
          if(!$productTags->contains(function ($productTag) use ($productTagsId) {
              return $productTag->id == $productTagsId;
          }))
          {
            $invalidTags .= ' '.$productTagsId;
          }
        }
        if(strlen($invalidTags) > 0)
        {
            throw (new ProductTagDontBelongToThisCompanyException($invalidTags));
        }
        }

        $product = new Product($productData);
        $user->company->products()->save($product);
        $product->productTags()->attach($productData['product_tags_id'] ?? []);
        foreach ($request->translations as $key => $value) {
            $product->languages()->attach($value['languageId'], ['name' => $value['name'], 'description' => $value['description']]);
        }

        return new ProductResource($product);
    }

    public function deleteProduct(Product $product)
    {
        $user = Auth::user();
        $company = $user->company->products;
        setPermissionsTeamId($user->company->id);
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
        }
        if (!$company->contains($product)) {
            throw (new ProductNotFoundException());
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
        $products =  QueryBuilder::for($user->company->products())->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::exact('verificationStatus', 'verification_status'),
            AllowedFilter::exact('subcategoryId', 'product_subcategory_id'),
            AllowedFilter::custom('categoryId', new ProductCategoryFilter()),
            AllowedFilter::custom('name', new ProductNameFilter()),
        ])->fastPaginate(config('paginationConfig.COMPANY_PRODUCTS'));
        $pagination = $this->paginate($products);

        return array_merge($pagination, ProductResource::collection($products)->toArray(request()));
    }

    public function editProduct(ProductDto $request, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if (!$user->can('Owner permissions')) {
            throw (new WrongPermissions());
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
        foreach ($request->translations as $key => $value) {
            $product->languages()->updateExistingPivot([$product->id, $key], ['name' => $value['name'], 'description' => $value['description']]);
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
        foreach ($requestProducts as $productId) {
            if (!$companyProducts->contains('id', $productId)) {
                throw (new ProductNotFoundException());
            }
            $product = Product::findOrFail($productId);
            $product->update(['status' => $status]);
        }
        return 1;
    }
}
