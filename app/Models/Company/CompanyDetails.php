<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'email',
        'phone_number',
        'external_website',
        'logo',
        'company_id',
        'tax_number',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
