<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Schedule"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="loan_id", type="integer", example="14"),
 * @OA\Property(property="amount", type="number", format="double", example="14.43"),
 * @OA\Property(property="due_date", type="date" , example="2020-10-20"),
 * @OA\Property(property="status", type="string", enum={"pending", "paid", "overdue"},  example="overdue"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Schedule
 *
 */
class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['due_date'];

    public function loan()
    {
    	return $this->belongsTo(Loan::class, 'loan_id');
    }
}
