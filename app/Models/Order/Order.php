<?php

namespace App\Models\Order;

use App\Models\Offers\Offers;
use App\Models\Company\Company;
use App\Models\Product\ProductOffer;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'id',
        'status',
        'company_id',
        'buyer_id',
        'seller_id',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function orderItems(): BelongsToMany
    {
        return $this->belongsToMany(ProductOffer::class, 'order_product_offer')
            ->withPivot(['offer_quantity']);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'seller_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'buyer_id');
    }
    
    public function orderProductOffers(): HasMany
    {
        return $this->hasMany(OrderProductOffer::class, 'order_id');
    }
}
