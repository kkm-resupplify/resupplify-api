<?php

namespace App\Services\Product;


use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Helpers\PaginationTrait;
use App\Models\Language\Language;
use App\Http\Controllers\Controller;
use App\Http\Dto\Product\ProductDto;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Storage;
use App\Filters\Product\ProductNameFilter;
use App\Resources\Product\ProductResource;
use App\Exceptions\Company\WrongPermissions;
use App\Filters\Product\ProductCategoryFilter;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductTranslationException;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use App\Exceptions\Product\ProductTagDontBelongToThisCompanyException;

class ProductService extends Controller
{
    use PaginationTrait;

    public function createProduct(ProductDto $request)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        $languages = Language::all();

        foreach ($request->translations as $language) {
            $translationId = $language['languageId'];
            if (!$languages->contains($translationId)) {
                throw new ProductTranslationException();
            }
        }
        if ($request->translations < Count(Language::all())) {
            throw new ProductTranslationException();
        }
        $productData = [
            'producer' => $request->producer,
            'code' => $request->code,
            'product_unit_id' => $request->productUnitId,
            'product_subcategory_id' => $request->productSubcategoryId,
            'company_id' => $user->company->id,
            'status' => $request->status,
            'verification_status' => ProductVerificationStatusEnum::UNVERIFIED(),
            'product_tags_id' => $request->productTagsId,
            'image' => '',
        ];
        $productTags = $user->company->load('productTags')->productTags;
        $invalidTags = "";
        $productTagsId = Arr::get($productData, 'product_tags_id', []);
        if ($productData['product_tags_id'] !== null) {
            foreach ($productTagsId as $productTagsId) {
                if (!$productTags->contains(function ($productTag) use ($productTagsId) {
                    return $productTag->id == $productTagsId;
                })) {
                    $invalidTags .= ' ' . $productTagsId;
                }
            }
            if (strlen($invalidTags) > 0) {
                throw (new ProductTagDontBelongToThisCompanyException($invalidTags));
            }
        }

        $productTags = $user->company->load('productTags')->productTags;
        $invalidTags = "";
        $productTagsId = Arr::get($productData, 'product_tags_id', []);
        if ($productData['product_tags_id'] !== null) {
            foreach ($productTagsId as $productTagsId) {
                if (!$productTags->contains(function ($productTag) use ($productTagsId) {
                    return $productTag->id == $productTagsId;
                })) {
                    $invalidTags .= ' ' . $productTagsId;
                }
            }
            if (strlen($invalidTags) > 0) {
                throw new ProductTagDontBelongToThisCompanyException($invalidTags);
            }
        }
        if ($request->image) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePath = $request->image->storeAs('uploads', $fileName, 's3');

            Storage::disk('s3')->setVisibility($filePath, 'public');

            $productData['image'] = Storage::disk('s3')->url($filePath);
        }

        $product = new Product($productData);
        $user->company->products()->save($product);
        $product->productTags()->attach($productData['product_tags_id'] ?? []);

        foreach ($request->translations as $value) {
            $product->languages()->attach(
                $value['languageId'],
                ['name' => $value['name'], 'description' => $value['description']]
            );
        }

        return new ProductResource($product);
    }

    public function deleteProduct(Product $product)
    {
        $user = app('authUser');
        $company = $user->company->products;
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        if (!$company->contains($product)) {
            throw new ProductNotFoundException();
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
        $user = app('authUser');
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
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);

        $productData = $this->prepareProductData($request, $user, $product);

        $this->validateProductTags($productData, $user);

        $product->update($productData);

        $product->productTags()->sync($productData['product_tags_id'] ?? []);

        $this->syncTranslations($request, $product);

        $product->save();

        return new ProductResource($product);
    }

    private function prepareProductData(ProductDto $request, $user, $product)
    {
        $productData = [
            'producer' => $request->producer,
            'code' => $request->code,
            'product_unit_id' => $request->productUnitId,
            'product_subcategory_id' => $request->productSubcategoryId,
            'company_id' => $user->company->id,
            'status' =>  $request->status,
            'product_tags_id' => $request->productTagsId ?? [],
            'image' => $product->image // set current image as default
        ];

        if ($request->image) {
            $productData['image'] = $this->storeImage($request->image);
        }

        return $productData;
    }
    private function storeImage($image)
    {
        $fileName = time() . '_' . $image->getClientOriginalName();
        $filePath = $image->storeAs('uploads', $fileName, 's3');

        Storage::disk('s3')->setVisibility($filePath, 'public');

        return Storage::disk('s3')->url($filePath);
    }

    private function validateProductTags($productData, $user)
    {
        $productTags = $user->company->load('productTags')->productTags;
        $invalidTags = "";
        $productTagsId = Arr::get($productData, 'product_tags_id', []);

        foreach ($productTagsId as $productTagId) {
            if (!$productTags->contains(function ($productTag) use ($productTagId) {
                return $productTag->id == $productTagId;
            })) {
                $invalidTags .= ' ' . $productTagId;
            }
        }

        if (strlen($invalidTags) > 0) {
            throw new ProductTagDontBelongToThisCompanyException($invalidTags);
        }
    }

    private function syncTranslations($request, $product)
    {
        foreach ($request->translations as $translation) {
            $product->languages()->syncWithoutDetaching([
                $translation['languageId'] => [
                    'name' => $translation['name'],
                    'description' => $translation['description']
                ]
            ]);
        }
    }

    public function massAssignProductStatus(Request $request)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        $companyProducts = $user->company->products;
        $requestProducts = $request->productIdList;
        $status = $request->status;
        foreach ($requestProducts as $productId) {
            if (!$companyProducts->contains('id', $productId)) {
                throw new ProductNotFoundException();
            }
            $product = Product::findOrFail($productId);
            $product->update(['status' => $status]);
        }
        return 1;
    }

    public function getProductStats()
    {
        $user = app('authUser');
        $company = $user->company;
        $products = $company->products;

        $productsAwaitingVerification = $products->where(
            'verification_status',
            ProductVerificationStatusEnum::UNVERIFIED()
        )->count();
        $verifiedProducts = $products->where('verification_status', ProductVerificationStatusEnum::VERIFIED())->count();
        $rejectedProducts = $products->where('verification_status', ProductVerificationStatusEnum::REJECTED())->count();
        $activeProducts = $products->where('status', ProductStatusEnum::ACTIVE())->count();
        $inactiveProducts = $products->where('status', ProductStatusEnum::INACTIVE())->count();
        $productsTotal = $products->count();

        return [
            'productsTotal' => $productsTotal,
            'productsAwaitingVerification' => $productsAwaitingVerification,
            'verifiedProducts' => $verifiedProducts,
            'rejectedProducts' => $rejectedProducts,
            'activeProducts' => $activeProducts,
            'inactiveProducts' => $inactiveProducts
        ];
    }
}
