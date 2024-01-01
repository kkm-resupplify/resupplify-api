<?php

namespace App\Models\Order;

use App\Models\Product\ProductOffer;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProductOffer extends Pivot
{
    protected $table = 'order_product_offer';
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
        'description',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productOffer()
    {
        return $this->belongsTo(ProductOffer::class);
    }
}
