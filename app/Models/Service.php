<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Service"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", example="7383"),
 * @OA\Property(property="serviceCode", type="string",  example="SDHE33"),
 * @OA\Property(property="category", type="string" , example="Service Category"),
 * @OA\Property(property="description", type="string" , example="Service Description"),
 * @OA\Property(property="request_date", type="date" , example="2020-10-20"),
 * @OA\Property(property="payment_method", type="string" , example="Payment Method"),
 * @OA\Property(property="status", type="string" , enum={"registered", "approved", "denied", "completed"}, example="Service Category"),
 * @OA\Property(property="closed", type="boolean", example="true"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Service
 *
 */
class Service extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
    	return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function field()
    {
        return $this->hasOne(ServiceField::class);
    }
}
