<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['available_quantity', 'description', 'external_link'];

    public function companyProduct(): BelongsTo
    {
        return $this->belongsTo(CompanyProduct::class);
    }

    public function productUnit(): HasOne
    {
        return $this->hasOne(ProductUnit::class);
    }
}
