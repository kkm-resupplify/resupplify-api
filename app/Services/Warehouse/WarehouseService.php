<?php

namespace App\Services\Warehouse;

use App\Exceptions\Company\WrongPermissions;
use App\Exceptions\Warehouse\WarehouseDataNotAccessible;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Warehouse\WarehouseDto;
use App\Models\Warehouse\Warehouse;
use App\Resources\Warehouse\WarehouseResource;
use App\Services\BasicService;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WarehouseService extends BasicService
{
    use PaginationTrait;
    public function createWarehouse(WarehouseDto $request)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if(!$user->can('Owner permissions')) {
        //     throw(new WrongPermissions());
        // }
        $warehouseData = [
            'name' => $request->name,
            'description' =>$request->description,
            'company_id' => $user->company->id,
        ];
        $warehouse = new Warehouse($warehouseData);
        $user->company->warehouses()->save($warehouse);
        return new WarehouseResource($warehouse);
    }

    public function getWarehouse(Warehouse $warehouse)
    {
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        return new WarehouseResource($warehouse);
    }

    public function getWarehouses()
    {
        $warehouses= QueryBuilder::for(Warehouse::where('company_id', '=', app('authUser')->company->id))
            ->allowedFilters(AllowedFilter::partial('name'))->fastPaginate(config('paginationConfig.WAREHOUSES'));
        $pagination = $this->paginate($warehouses);
        return array_merge($pagination, WarehouseResource::collection($warehouses)->toArray(request()));
    }

    public function editWarehouse(WarehouseDto $request, Warehouse $warehouse)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if(!$user->can('Owner permissions')) {
        //     throw(new WrongPermissions());
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $warehouse->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return new WarehouseResource($warehouse);
    }

    public function deleteWarehouse(Warehouse $warehouse)
    {
        $user = app('authUser');
        setPermissionsTeamId($user->company->id);
        // if(!$user->can('Owner permissions')) {
        //     throw(new WrongPermissions());
        // }
        $warehouses = app('authUser')->company->warehouses;
        if (!$warehouses->contains($warehouse))
        {
            throw(new WarehouseDataNotAccessible());
        }
        $warehouse->delete();
        return 1;
    }
}
