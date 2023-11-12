<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product\Product;

class ProductUnit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['code'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
