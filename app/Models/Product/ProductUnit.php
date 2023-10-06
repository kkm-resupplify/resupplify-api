<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol'];

    public function companyProduct(): BelongsTo
    {
        return $this->belongsTo(CompanyProductDetails::class);
    }
}
