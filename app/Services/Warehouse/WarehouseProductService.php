<?php

namespace App\Services\Warehouse;

use App\Services\BasicService;
use App\Models\Product\Product;
use App\Helpers\PaginationTrait;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Filters\Product\ProductNameFilter;
use App\Resources\Product\ProductResource;
use App\Exceptions\Company\WrongPermissions;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Exceptions\Product\ProductNotFoundException;
use App\Resources\Warehouse\WarehouseProductResource;
use App\Exceptions\Warehouse\WarehouseDataNotAccessible;
use App\Exceptions\Product\ProductExistsInWarehouseException;
use App\Exceptions\Warehouse\WarehouseProductQuantityException;
use App\Http\Dto\Warehouse\WarehouseProductMassStatusUpdateDto;

class WarehouseProductService extends BasicService
{
    use PaginationTrait;
    public function createWarehouseProduct(WarehouseProductDto $request, Warehouse $warehouse, Product $product)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }
        if ($warehouse->products->contains($product)) {
            throw new ProductExistsInWarehouseException();
        }
        if ($product->company_id != $user->company->id) {
            throw new ProductNotFoundException();
        }
        if($request->quantity < 0)
        {
            throw new WarehouseProductQuantityException();
        }
        if (isset($request->status)) {
            $warehouseProductData = [
                'quantity' => $request->quantity,
                'safe_quantity' => $request->safeQuantity,
                'status' => $request->status,
            ];
        } else {
            $warehouseProductData = [
                'quantity' => $request->quantity,
                'safe_quantity' => $request->safeQuantity,
                'status' => 0,
            ];
        }
        $product->warehouses()->attach($warehouse->id, $warehouseProductData);
        return new WarehouseProductResource($product->warehouses()->find($warehouse->id)
            ->products()->find($product->id));
    }

    public function getAllWarehouseProducts(Warehouse $warehouse)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);

        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }

        $warehouses = app('authUser')->company->warehouses;

        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }

        $warehouseProducts = QueryBuilder::for($warehouse->products())
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::custom('name', new ProductNameFilter()),
            ])
            ->fastPaginate(config('paginationConfig.WAREHOUSE_PRODUCTS'));
            $pagination = $this->paginate($warehouseProducts);
            return array_merge($pagination, WarehouseProductResource::collection($warehouseProducts)->toArray(request()));
    }

    public function getWarehouseProduct(Warehouse $warehouse, Product $product)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }
        $productWarehouses = $warehouse->products->where('id', $product->id)->first();
        if (!$productWarehouses) {
            return [];
        }
        return new WarehouseProductResource($productWarehouses);
    }

    public function updateWarehouseProduct(WarehouseProductDto $request, Warehouse $warehouse, Product $product)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }

        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }

        $productWarehouses = $warehouse->products->where('id', $product->id)->first();
        if (!isset($productWarehouses)) {
            throw new ProductNotFoundException();
        }

        $warehouse->products()->updateExistingPivot($productWarehouses->id, [
            'quantity' => $request->quantity,
            'safe_quantity' => $request->safeQuantity,
            'status' => $request->status,
        ]);
        return 1;
    }

    public function detachWarehouseProduct(Warehouse $warehouse, Product $product)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }
        $productWarehouses = $warehouse->products->where('id', $product->id)->first();
        if (!isset($productWarehouses)) {
            throw new ProductNotFoundException();
        }
        $product->warehouses()->detach($warehouse->id);
        return 1;
    }

    public function getProductsNotInWarehouse(Warehouse $warehouse)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if (!$user->can('Owner permissions')) {
        //     throw new WrongPermissions();
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse)) {
            throw new WarehouseDataNotAccessible();
        }
        $companyProducts = $user->company->products;
        return ProductResource::collection($companyProducts->whereNotIn('id', $warehouse->products->pluck('id')->values()));
    }

    public function massAssignProductStatus(WarehouseProductMassStatusUpdateDto $statusUpdateDTO)
    {
        $warehouse = Warehouse::find($statusUpdateDTO->warehouseId);

        foreach ($statusUpdateDTO->warehouseProductIds as $warehouseProductId) {
            $warehouse->products()->updateExistingPivot($warehouseProductId, ['status' => $statusUpdateDTO->newStatus]);
        }

        return ['status' => $statusUpdateDTO->newStatus];
    }
}
