<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Agent"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="code", type="string", example="Agent Code"),
 *  @OA\Property(property="name", type="string", example="Agent Name"),
 *  @OA\Property(property="label", type="string", example="Agent Label"),
 *  @OA\Property(property="path", type="string", example="Storage Path"),
 *   @OA\Property(property="short_name", type="string", example="Agent Short Name"),
 * @OA\Property(property="status", type="string", enum={"pending","inReview","verified"}, example="verified"),
 * @OA\Property(property="isActive", type="boolean", example="True"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Agent
 *
 */
class Agent extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function beneficiary()
    {
        return $this->morphOne(Beneficiary::class, 'beneficiaryable');
    }
}
