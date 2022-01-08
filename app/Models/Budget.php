<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Budget"),
 * @OA\Property(property="id", type="integer", example="05"),
 * @OA\Property(property="description", type="string", example="Budget Description"),
 * @OA\Property(property="code", type="string", example="Budget Code"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Budget
 *
 */
class Budget extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $dates = ['start', 'end'];

    public function getRouteKeyName()
    {
    	return 'code';
    }

    public function heads()
    {
        return $this->hasMany(BudgetHead::class);
    }
}
