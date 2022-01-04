<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Fund"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="budget_head_id", type="integer", example="14"),
 * @OA\Property(property="description", type="string", example="Fund Description"),
 * @OA\Property(property="approved_amount", type="number", format="double" , example="50003490.45"),
 * @OA\Property(property="booked_expenditure", type="number", format="double" , example="50003490.45"),
 * @OA\Property(property="actual_expenditure", type="number", format="double" , example="50003490.45"),
 * @OA\Property(property="booked_balance", type="number", format="double" , example="50003490.45"),
 * @OA\Property(property="actual_balance", type="number", format="double" , example="50003490.45"),
 * @OA\Property(property="expected_performance", type="integer", example="90"),
 * @OA\Property(property="actual_performance", type="integer", example="80"),
 * @OA\Property(property="year", type="integer" , example="2021"),
 * @OA\Property(property="exhausted", type="boolean", example="True"),
 * @OA\Property(property="deactivated", type="boolean", example="False"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Fund
 *
 */
class Fund extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function budgetHead()
    {
    	return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }
}
