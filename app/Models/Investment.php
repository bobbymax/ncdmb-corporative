<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Investment"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="category_id", type="integer", example="14"),
 * @OA\Property(property="title", type="string" , example="Investment Title"),
 * @OA\Property(property="label", type="string", example="Investment Label"),
 * @OA\Property(property="description", type="string", example="Investment description"),
 * @OA\Property(property="date_acquired", type="date", example="2020-10-20"),
 * @OA\Property(property="expiry_date", type="date", example="2020-10-20"),
 * @OA\Property(property="amount", type="number", format="double", example="Invest Label"),
 * @OA\Property(property="allocations", type="integer", example="74"),
 * @OA\Property(property="closed", type="boolean"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Investment
 *
 */
class Investment extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['date_acquired', 'expiry_date'];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    public function specifications()
    {
    	return $this->hasMany(Specification::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
