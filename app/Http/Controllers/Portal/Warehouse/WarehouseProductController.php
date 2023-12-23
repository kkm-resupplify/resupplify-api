<?php

namespace App\Http\Controllers\Portal\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Http\Dto\Warehouse\WarehouseProductMassStatusUpdateDto;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Services\Warehouse\WarehouseProductService;


class WarehouseProductController extends Controller
{
    public function store(WarehouseProductService $warehouseProductService, WarehouseProductDto $request)
    {
        $warehouse = Warehouse::findOrFail($request->warehouseId);
        $product = Product::findOrFail($request->productId);
        return $this->ok($warehouseProductService->createWarehouseProduct($request, $warehouse, $product));
    }

    public function update(
        WarehouseProductService $warehouseProductService,
        Warehouse $warehouse,
        Product $product,
        WarehouseProductDto $request
    ) {
        return $this->ok($warehouseProductService->updateWarehouseProduct($request, $warehouse, $product));
    }


    public function destroy(WarehouseProductService $warehouseProductService, Warehouse $warehouse, Product $product)
    {
        return $this->ok($warehouseProductService->detachWarehouseProduct($warehouse, $product));
    }

    public function show(WarehouseProductService $warehouseProductService, Warehouse $warehouse, Product $product)
    {
        return $this->ok($warehouseProductService->getWarehouseProduct($warehouse, $product));
    }

    public function index(WarehouseProductService $warehouseProductService, Warehouse $warehouse)
    {
        return $this->ok($warehouseProductService->getAllWarehouseProducts($warehouse));
    }

    public function productsNotInWarehouse(WarehouseProductService $warehouseProductService, Warehouse $warehouse)
    {
        return $this->ok($warehouseProductService->getProductsNotInWarehouse($warehouse));
    }

    public function massAssignProductStatus(
        WarehouseProductService $warehouseProductService,
        WarehouseProductMassStatusUpdateDto $updateStatusDto
    ) {
        return $this->ok($warehouseProductService->massAssignProductStatus($updateStatusDto));
    }
}
