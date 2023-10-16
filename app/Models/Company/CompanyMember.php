<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Company\Company;
use App\Models\Company\CompanyCategory;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyProduct;
use App\Models\Company\CompanyProductDetails;
use App\Models\Company\CompanyRole;
use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Models\Country\Country;
use App\Models\Country\CountryDetails;

class CompanyMember extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'role_id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
