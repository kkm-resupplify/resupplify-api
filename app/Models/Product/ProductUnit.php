<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'symbol'];

    // TODO
    // - change this to hasmany
    // - remove companyproductdetails

    public function companyProduct(): BelongsTo
    {
        return $this->belongsTo(CompanyProductDetails::class);
    }
}
