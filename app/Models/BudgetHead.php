<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="BudgetHead"),
 * @OA\Property(property="id", type="integer", example="05"),
 * @OA\Property(property="budget_id", type="integer", example="383"),
 * @OA\Property(property="code", type="string", example="Budget Code"),
 * @OA\Property(property="description", type="string", example="Budget Description"),
 *  @OA\Property(property="category", type="string", example="Budget Category"),
 *  @OA\Property(property="interest", type="integer", example="budget interest"),
 *  @OA\Property(property="restriction", type="integer", example="budget restriction"),
 *  @OA\Property(property="commitment", type="integer", example="budget commitment"),
 *  @OA\Property(property="limit", type="number", format="double", example="budget limit"),
 *  @OA\Property(property="payable", type="string"),
 *  @OA\Property(property="frequency", type="string"),
 *  @OA\Property(property="type", type="string", enum={"capital", "recursive", "personnel"}, example="capital"),
 *  @OA\Property(property="active", type="boolean", example="true"),
 *  @OA\Property(property="year", type="integer"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class BudgetHead
 *
 */
class BudgetHead extends Model
{
    use HasFactory;

    protected $guarded = [''];

    // public function getRouteKeyName()
    // {
    // 	return 'code';
    // }

    public function budget()
    {
    	return $this->belongsTo(Budget::class, 'budget_id');
    }

    // public function fund()
    // {
    //     return $this->hasOne(Fund::class, 'budget_head_id');
    // }

    public function fund($yr)
    {
        return $this->funding->where('year', $yr)->first();
    }

    public function funding()
    {
        return $this->hasMany(Fund::class, 'budget_head_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
