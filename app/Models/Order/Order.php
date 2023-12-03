<?php

namespace App\Models\Order;

use App\Models\Company\Company;
use App\Models\Offers\Offers;
use App\Models\Order\Enums\OrderStatusEnum;
use App\Models\Product\ProductOffers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'id',
        'status',
        'company_id',
    ];

    protected $casts = [
      'status' => OrderStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function productOffers(): BelongsToMany
    {
        return $this->belongsToMany(ProductOffers::class, 'product_warehouse')
        ->withPivot(['quantity','safe_quantity','status']);
    }

}