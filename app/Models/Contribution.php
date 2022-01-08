<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Contribution"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", example="14"),
 * @OA\Property(property="fee", type="number", format="double",  example="Specification Title"),
 * @OA\Property(property="month", type="string",  example="contribution month"),
 * @OA\Property(property="current", type="boolean",  example="true"),
 * @OA\Property(property="previous", type="json", example="2302.2"),
* @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Contribution
 *
 */
class Contribution extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
