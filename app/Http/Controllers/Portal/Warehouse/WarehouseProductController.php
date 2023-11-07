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
    public function store(WarehouseProductService $warehouseProductService, WarehouseProductDto $request, Request $requestId)
    {
        $warehouse = Warehouse::findOrFail($requestId->warehouseId);
        $product = Product::findOrFail($requestId->productId);
        return $this->ok($warehouseProductService->createWarehouseProduct($request, $warehouse, $product));
    }

    // public function show(WarehouseService $warehouseService, Warehouse $warehouse)
    // {
    //     return $this->ok($warehouseService->getWarehouse($warehouse));
    // }
    // public function index(WarehouseService $warehouseService)
    // {
    //     return $this->ok($warehouseService->getWarehouses());
    // }

    // public function update(WarehouseService $warehouseService, WarehouseDto $request, Warehouse $warehouse)
    // {
    //     return $this->ok($warehouseService->editWarehouse($request, $warehouse));
    // }

    public function destroy(WarehouseProductService $warehouseService, Warehouse $warehouse,Product $product)
    {
        return $this->ok($warehouseService->detachWarehouseProduct($warehouse,$product));
    }
}
