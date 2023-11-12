<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'address',
        'email',
        'phone_number',
        'external_website',
        'logo',
        'company_id',
        'tin',
        'country_id',
        'company_category_id',
        'contact_person'

    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
