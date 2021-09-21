<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [''];

    protected $dates = ['date_joined'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'staff_no';
    }

    public function getFullname()
    {
        return $this->firstname . " "  . $this->middlename ?? null .  " " . $this->surname;
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function contribution()
    {
        return $this->contributions->where('current', true);
    }

    public function roles()
    {
        return $this->morphedByMany(Role::class, 'userable');
    }

    public function groups()
    {
        return $this->morphedByMany(Group::class, 'userable');
    }

    public function kin()
    {
        return $this->hasOne(Kin::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function approvals()
    {
        return $this->morphedByMany(Loan::class, 'approveable')->withPivot('remark', 'status');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function guaranteed()
    {
        return $this->morphedByMany(Loan::class, 'guarantorable')->withPivot('remarks', 'status');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactee::class);
    }

    public function currentRoles()
    {
        return $this->roles->pluck('id')->toArray();
    }

    public function actAs(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function beneficiary()
    {
        return $this->morphOne(Beneficiary::class, 'beneficiaryable');
    }

    public function payments()
    {
        return $this->hasMany(Pay::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('label', $role);
        }

        foreach ($role as $r) {
            if ($this->hasRole($r->label)) {
                return true;
            }
        }

        return false;
    }
}
