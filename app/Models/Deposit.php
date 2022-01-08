<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Deposit"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", example="14"),
 * @OA\Property(property="trxRef", type="string", example="Transaction Reference"),
 * @OA\Property(property="amount", type="number", format="double",  example="3434.34"),
 * @OA\Property(property="paid", type="boolean",  example="true"),
* @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Deposit
 *
 */
class Deposit extends Model
{
    use HasFactory;

    public $guarded = [''];

    public function transactions()
    {
    	return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
