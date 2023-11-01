<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Company\Company;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;

class Product extends Model
{
    use HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'verification_status',
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
        'verification_status' => ProductVerificationStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class);
    }
}
