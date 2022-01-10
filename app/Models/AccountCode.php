<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="AccountCode"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="range", type="string", example="Account code range"),
 * @OA\Property(property="name", type="string", example="Account code Name"),
 * @OA\Property(property="label", type="string", example="144"),
 * @OA\Property(property="isActive", type="boolean", example="True"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class AccountCode
 *
 */
class AccountCode extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
