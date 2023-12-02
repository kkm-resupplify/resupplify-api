<?php

namespace App\Models\Product;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductOffers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_id',
        'price',
        'productQuantity',
        'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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

}
