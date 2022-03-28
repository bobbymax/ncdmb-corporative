<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 *  @OA\Schema(
 *  @OA\Xml(name="Approval"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="user_id", type="integer", example="637434"),
 *  @OA\Property(property="remark", type="string", example="Remarks (Long text)"),
 *  @OA\Property(property="status", type="string", enum={"pending","approved","review", "declined"}, example="pending"),
 *  @OA\Property(property="approvable_id", type="integer", example="345"),
 *  @OA\Property(property="approvable_type", type="string", example="Approvable Type"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Approval
 *
 */
class Approval extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function loans()
    {
        return $this->morphedByMany(Loan::class, 'approveable')->withPivot('remark', 'status');
    }
}
