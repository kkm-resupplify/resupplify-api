<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserInvitationCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'role_id',
        'expiry_date',
        'is_used',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
