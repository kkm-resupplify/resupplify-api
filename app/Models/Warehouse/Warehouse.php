<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Company\Company;
use App\Models\Warehouse\Enums\WarehouseStatusEnum;

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
        return $this->belongsToMany(Product::class);
    }
}
