<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Http\Controllers\Controller;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Auth;



class WarehouseService extends Controller
{
    //create warehouse
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

}
