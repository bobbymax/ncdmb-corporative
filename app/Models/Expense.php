<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Expense"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="user_id", type="integer", example="Expense ID"),
 * @OA\Property(property="budget_head_id", type="integer", example="Expense ID"),
 * @OA\Property(property="receive_id", type="integer", example="Treceiver ID"),
 * @OA\Property(property="reference", type="string", example="Expense reference"),
 * @OA\Property(property="due_date", type="date", example="2020-20-10"),
 * @OA\Property(property="amount", type="number", format="float", example=" Amount"),
 * @OA\Property(property="description", type="string", example="Expense Description"),
 * @OA\Property(property="currency", type="string", enum={"NGN", "USD", "GBP"}, example="NGN"),
 * @OA\Property(property="status", type="string", enum={"pending", "batched", "paid"}, example="paid"),
 *  @OA\Property(property="completed", type="boolean",  example="true"),
 *   @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Expense
 *
 */
class Expense extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $dates = ['due_date'];

    public function receiver()
    {
        return $this->belongsTo(Receive::class, 'receive_id');
    }

    public function budgetHead()
    {
        return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }

    public function batchEntries()
    {
        return $this->morphMany(BatchEntry::class, 'batchable');
    }

}
