<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Permission"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="key", type="string", example="Permission Key"),
 * @OA\Property(property="name", type="string",  example="Permission Name"),
 * @OA\Property(property="module", type="string" , example="Module Name"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Permission
 *
 */
class Permission extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function roles()
    {
    	return $this->morphedByMany(Role::class, 'permissionable');
    }

    public function groups()
    {
    	return $this->morphedByMany(Group::class, 'permissionable');
    }
}
