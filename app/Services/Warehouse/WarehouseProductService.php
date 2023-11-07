<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Warehouse\WarehouseDataNotAccessible;
use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
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
        $warehouseProductData = [
            'quantity' => $request->quantity,
            'safe_quantity' => $request->safeQuantity,
        ];
        $product-> warehouses()->attach($warehouse->id, $warehouseProductData);
        return $warehouseProductData;
    }
}
