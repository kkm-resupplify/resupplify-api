<?php

namespace App\Http\Controllers\Portal\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Services\Warehouse\WarehouseProductService;
use Illuminate\Http\Request;


class WarehouseProductController extends Controller
{
    public function store(WarehouseProductService $warehouseProductService, WarehouseProductDto $request)
    {
        $warehouse = Warehouse::findOrFail($request->warehouseId);
        $product = Product::findOrFail($request->productId);
        return $this->ok($warehouseProductService->createWarehouseProduct($request, $warehouse, $product));
    }

    // public function show(WarehouseService $warehouseProductService, Warehouse $warehouse)
    // {
    //     return $this->ok($warehouseProductService->getWarehouse($warehouse));
    // }
    // public function index(WarehouseService $warehouseProductService)
    // {
    //     return $this->ok($warehouseProductService->getWarehouses());
    // }

    public function update(WarehouseProductService $warehouseProductService, Warehouse $warehouse,Product $product,WarehouseProductDto $request)
    {
        return $this->ok($warehouseProductService->updateWarehouseProduct($request,$warehouse,$product));
    }

    public function destroy(WarehouseProductService $warehouseProductService, Warehouse $warehouse,Product $product)
    {
        return $this->ok($warehouseProductService->detachWarehouseProduct($warehouse,$product));
    }
}
