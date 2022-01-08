<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Wallet"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", example="14"),
 * @OA\Property(property="identifier", type="string",  example="Identifier"),
 * @OA\Property(property="deposit", type="number", format="double", example="2329.23"),
 * @OA\Property(property="current", type="number", format="double", example="2329.23"),
 * @OA\Property(property="available", type="number", format="double", example="2329.23"),
 * @OA\Property(property="ledger", type="number", format="double", example="2329.23"),
 * @OA\Property(property="bank_name", type="string",  example="Access Bank PLC"),
 * @OA\Property(property="account_number", type="string",  example="8833783738"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Wallet
 *
 */
class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'identifier';
    }

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
