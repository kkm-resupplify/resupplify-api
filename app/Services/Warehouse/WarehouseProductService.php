<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Http\Dto\Warehouse\WarehouseProductDto;
use App\Models\Warehouse\Warehouse;
use App\Resources\Warehouse\WarehouseResource;
use Illuminate\Support\Facades\Auth;



class WarehouseProductService extends Controller
{
    public function createWarehouseProduct(WarehouseProductDto $request,Warehouse $warehouse)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouseProductData = [
            'quantity' => $request->quantity,
            'safe_quantity' => $request->safeQuantity,
            'warehouse_id' => $warehouse->id,
            'company_id' => $user->company->id,
        ];
        return $warehouseProductData;
    }
}
