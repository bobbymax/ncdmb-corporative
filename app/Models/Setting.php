<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function roles()
    {
        return $this->morphToMany(Role::class, 'roleable');
    }

    public function allowRoleAccessSetting(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function currentRoles()
    {
        return $this->roles->pluck('id')->toArray();
    }
}
