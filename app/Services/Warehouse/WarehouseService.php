<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Auth;



class WarehouseService extends Controller
{
    public function createWarehouse(WarehouseDto $request)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouseData = [
            'name' => $request->name,
            'description' =>$request->description,
            'company_id' => $user->company->id,
        ];
        $warehouse = new Warehouse($warehouseData);
        $user->company->warehouses()->save($warehouse);
        return $warehouse;
    }

    public function getWarehouse(Warehouse $warehouse)
    {
        return $warehouse;
    }

    public function getWarehouses()
    {
        return Warehouse::where('company_id', '=', Auth::user()->company->id)->get();
    }

    public function editWarehouse(WarehouseDto $request, Warehouse $warehouse)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouse->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return $warehouse;
    }

    public function deleteWarehouse(Warehouse $warehouse)
    {
        $user = Auth::user();
        setPermissionsTeamId($user->company->id);
        if(!$user->can('Owner permissions')) {
            throw(new WrongPermissions());
        }
        $warehouse->delete();
        return 1;
    }
}
