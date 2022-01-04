<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Beneficiary"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="payment_code", type="string", readOnly="true", example="sdg6"),
 * @OA\Property(property="beneficiaryable_id", type="integer", readOnly="true", example="1"),
  * @OA\Property(property="beneficiaryable_type", type="string", readOnly="true", example="Type"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Beneficiary
 *
 */
class Beneficiary extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
        return 'payment_code';
    }

    public function payments()
    {
    	return $this->hasMany(Pay::class);
    }

    public function beneficiaryable()
    {
    	return $this->morphTo();
    }
}
