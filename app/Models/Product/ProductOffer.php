<?php

namespace App\Models\Product;


use App\Models\Order\Order;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductOffer extends Model
{
    use HasFactory, SoftDeletes;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'id',
        'company_product_id',
        'price',
        'product_quantity',
        'status',
        'started_at',
        'ended_at',
        'company_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'started_at', 'ended_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function productWarehouse(): BelongsTo
    {
        return $this->belongsTo(ProductWarehouse::class, 'company_product_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product_offer')
            ->withPivot(['offerQuantity']);
    }

    public function productCarts(): BelongsToMany
    {
        return $this->belongsToMany(ProductCart::class, 'order_product_offer')
            ->withPivot(['offerQuantity']);
    }

    public function product()
    {
        return $this->belongsToThrough(
            Product::class,
            ProductWarehouse::class,
            null,
            '',
            [ProductWarehouse::class => 'company_product_id', Product::class => 'product_id']
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
