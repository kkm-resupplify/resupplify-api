<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyMember extends Model
{
    use HasFactory;
    use SoftDeletes;

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
