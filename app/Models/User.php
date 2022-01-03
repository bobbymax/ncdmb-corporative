<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="User"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="membership_no", type="string", example="Membership Number"),
 *  @OA\Property(property="staff_no", type="string", example="Staff Number"),
 *  @OA\Property(property="designation", type="string", example="Designation"),
 *  @OA\Property(property="firstname", type="string", example="John"),
 *   @OA\Property(property="middlename", type="string", example="F."),
 *  @OA\Property(property="surname", type="String", example="Doe"),
 * @OA\Property(property="email", type="String", example="john@ncdmb.ng"),
 * @OA\Property(property="mobile", type="String", example="08127820880"),
 * @OA\Property(property="location", type="String", example="Abuja"),
 * @OA\Property(property="type", type="string", enum={"member","exco"}, example="exco"),
 *  @OA\Property(property="date_joined", type="date", example="2020-10-20"),
 * @OA\Property(property="can_guarantee", type="boolean", example="True"),
 * @OA\Property(property="has_loan", type="boolean", example="True"),
 * @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
 * @OA\Property(property="email_verified_at", type="date", example="2020-10-20"),
 * @OA\Property(property="password", type="string", example="password"),
 * @OA\Property(property="remember_token", type="string", example="e8ryhqwer3r38r9h3rq3rq"),
 * @OA\Property(property="avatar", type="string", example="path to avatar"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 *  @OA\Property(property="deleted_at", type="date", example="2020-12-22"),
 *  @OA\Property(property="passwordChange", type="boolean", example="True"),
 * )
 * Class User
 *
 */
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
