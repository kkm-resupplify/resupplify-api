<?php

namespace App\Models\Warehouse;

use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductOffer;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductWarehouse;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Warehouse\Enums\WarehouseStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Warehouse extends Model
{
    use HasRoles, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    protected $casts = [
        'status' => WarehouseStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_warehouse')
        ->withPivot(['quantity','safe_quantity','status']);
    }

    public function productOffers(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductOffer::class,
            ProductWarehouse::class,
            'warehouse_id',  
            'company_product_id', 
            'id', 
            'id' 
        );
    }

}
