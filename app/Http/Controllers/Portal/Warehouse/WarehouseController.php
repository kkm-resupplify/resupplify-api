<?php

namespace App\Http\Controllers\Portal\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Services\Warehouse\WarehouseService;


class WarehouseController extends Controller
{
    public function createWarehouse(WarehouseService $warehouseService, WarehouseDto $request)
    {
        return $this->ok($warehouseService->createWarehouse($request));
    }
}
