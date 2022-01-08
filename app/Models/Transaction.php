<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Transaction"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="transactionable_id", type="integer", example="14"),
 * @OA\Property(property="transactionable_type", type="string", example= "Type"),
 * @OA\Property(property="code", type="string",  example="Transaction code"),
 * @OA\Property(property="type", type="string",  example="Transaction Type"),
 * @OA\Property(property="amount", type="number", format="double", example="true"),
 * @OA\Property(property="status", type="string", enum={"pending", "disbursed", "paid", "unpaid"}, example="unpaid"),
 * @OA\Property(property="completed", type="boolean" ,example="true"),
* @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Transaction
 *
 */
class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function transactees()
    {
        return $this->hasMany(Transactee::class);
    }
}
