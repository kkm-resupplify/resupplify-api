<?php

namespace App\Models\Warehouse;

use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Warehouse\Enums\WarehouseStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

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
}
