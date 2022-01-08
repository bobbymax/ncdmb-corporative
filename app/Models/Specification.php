<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Specification"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="investment_id", type="integer", example="14"),
 * @OA\Property(property="title", type="string",  example="Specification Title"),
 * @OA\Property(property="label", type="string",  example="Specification Label"),
 * @OA\Property(property="description", type="string",  example="Specification description"),
 * @OA\Property(property="amount", type="number", format="double", example="2302.2"),
 * @OA\Property(property="slots", type="integer" , example="33"),
 * @OA\Property(property="status", type="string", enum={"pending", "exhausted"},  example="exhausted"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Specification
 *
 */
class Specification extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function investment()
    {
    	return $this->belongsTo(Investment::class, 'investment_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
