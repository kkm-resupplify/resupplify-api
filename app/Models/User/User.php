<?php

namespace App\Models\User;

use App\Models\Company\Company;
use App\Models\Company\CompanyMember;
use App\Models\Language\Language;
use App\Models\User\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = ['email', 'password', 'type', 'language_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserTypeEnum::class,
    ];

    public function companyMember(): HasOne
    {
        return $this->hasOne(CompanyMember::class);
    }

    public function userDetails(): HasOne
    {
        return $this->hasOne(UserDetails::class);
    }

    public function company()
    {
        return $this->hasOneThrough(
            Company::class,
            CompanyMember::class,
            'user_id',
            'id',
            'id',
            'company_id'
        );
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }
}
