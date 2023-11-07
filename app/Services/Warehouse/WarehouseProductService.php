<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Product\ProductExistsInWarehouseException;
use App\Exceptions\Warehouse\WarehouseDataNotAccessible;
use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Resources\Product\ProductResource;
use App\Resources\Warehouse\WarehouseProductResource;
use App\Resources\Warehouse\WarehouseResource;
use Illuminate\Support\Facades\Auth;



class WarehouseProductService extends Controller
{
    public function createWarehouseProduct(WarehouseProductDto $request,Warehouse $warehouse, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        if ($warehouse->products->contains($product))
        {
            throw(new ProductExistsInWarehouseException());
        }
        $warehouseProductData = [
            'quantity' => $request->quantity,
            'safe_quantity' => $request->safeQuantity,
            'status' => ProductStatusEnum::INACTIVE(),
        ];
        $product-> warehouses()->attach($warehouse->id, $warehouseProductData);
        return new WarehouseProductResource($product->warehouses()->find($warehouse->id)->products()->find($product->id));
    }
    //get all warehouse products
    public function getAllWarehouseProducts(Warehouse $warehouse)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $warehouseProducts = $warehouse->products;
        return WarehouseResource::collection($warehouseProducts);
    }
    //get all product warehouses
    public function getAllProductWarehouses(Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $productWarehouses = $product->warehouses;
        return WarehouseResource::collection($productWarehouses);
    }
    //get warehouse product
    public function getWarehouseProduct(Warehouse $warehouse, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $productWarehouses = $warehouse->products->where('product_id', $product->id)->first();
        if (!$productWarehouses->contains($product))
        {
            throw(new WarehouseDataNotAccessible());
        }
        return new WarehouseResource($productWarehouses);
    }
    //update warehouse product
    public function updateWarehouseProduct(WarehouseProductDto $request,Warehouse $warehouse, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $productWarehouses = $warehouse->products->where('product_id', $product->id)->first();
        if (!$productWarehouses->contains($product))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $warehouseProductData = [
            'quantity' => $request->quantity,
            'safe_quantity' => $request->safeQuantity,
        ];
        $productWarehouses->update($warehouseProductData);
        return $productWarehouses;
    }
    //detach warehouse from product
    public function detachWarehouseProduct(Warehouse $warehouse, Product $product)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouses = Auth::user()->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $productWarehouses = $warehouse->products->where('product_id', $product->id)->first();
        if (!$productWarehouses->contains($product))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $productWarehouses->detach();
        return $productWarehouses;
    }
}
