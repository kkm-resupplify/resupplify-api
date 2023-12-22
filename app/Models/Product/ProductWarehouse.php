<?php
namespace App\Models\Product;

use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use App\Models\Product\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWarehouse extends Pivot
{
    protected $table = 'product_warehouse';
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'status',
        'safe_quantity',
    ];
    protected $casts = [
        'status' => ProductStatusEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
