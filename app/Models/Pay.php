<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Pay"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="user_id", type="integer", example="Pay ID"),
 * @OA\Property(property="beneficiary_id", type="integer", example="Beneficiary ID"),
 * @OA\Property(property="trxRef", type="string", example="Transaction Reference"),
 * @OA\Property(property="payable_id", type="integer", example="Payable ID"),
 * @OA\Property(property="payable_type", type="string", example="Payable Type"),
 * @OA\Property(property="title", type="string", example="Pay Title"),
 * @OA\Property(property="label", type="string", example="Pay Label"),
 * @OA\Property(property="amount", type="number", format="float", example="Pay Amount"),
 * @OA\Property(property="type", type="string", enum={"member", "staff", "third-party"}, example="staff"),
 *  @OA\Property(property="status", type="string", enum={"pending", "refunded", "unpaid", "paid"}, example="paid"),
 *   @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Pay
 *
 */
class Pay extends Model
{
    use HasFactory;

    // protected $table = "pays";

    public function getRouteKeyName()
    {
    	return 'trxRef';
    }

    public function payable()
    {
    	return $this->morphTo();
    }

    public function beneficiary()
    {
    	return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function initiator()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
