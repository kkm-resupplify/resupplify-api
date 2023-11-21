<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Company\Company;
use App\Models\Product\Product;

class ProductTag extends Model
{
    use HasRoles;

    protected $fillable = ['name', 'color','slug', 'company_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
