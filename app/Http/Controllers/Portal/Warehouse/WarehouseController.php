<?php

namespace App\Http\Controllers\Portal\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Models\Warehouse\Warehouse;
use App\Services\Warehouse\WarehouseService;


class WarehouseController extends Controller
{
    public function store(WarehouseService $warehouseService, WarehouseDto $request)
    {
        return $this->ok($warehouseService->createWarehouse($request));
    }

    public function show(WarehouseService $warehouseService, Warehouse $warehouse)
    {
        return $this->ok($warehouseService->getWarehouse($warehouse));
    }
    public function index(WarehouseService $warehouseService)
    {
        return $this->ok($warehouseService->getWarehouses());
    }

    public function update(WarehouseService $warehouseService, WarehouseDto $request, Warehouse $warehouse)
    {
        return $this->ok($warehouseService->editWarehouse($request, $warehouse));
    }

    public function destroy(WarehouseService $warehouseService, Warehouse $warehouse)
    {
        return $this->ok($warehouseService->deleteWarehouse($warehouse));
    }
}
