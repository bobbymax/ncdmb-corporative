<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Role"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", example="Role name"),
 * @OA\Property(property="label", type="string",  example="Role Label"),
 * @OA\Property(property="slots", type="integer" , example="50"),
 * @OA\Property(property="deactivated", type="boolean", example="true"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Role
 *
 */
class Role extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function members()
    {
    	return $this->morphToMany(User::class, 'userable');
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'permissionable');
    }
}
