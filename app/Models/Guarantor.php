<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Guarantor"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="loan_id", type="integer", example="14"),
 * @OA\Property(property="user_id", type="integer", example="73"),
 * @OA\Property(property="remark", type="string" , example="Remark"),
 * @OA\Property(property="status", type="string", enum={"pending", "approved", "denied"}, example="denied"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Guarantor
 *
 */
class Guarantor extends Model
{
    protected $table = 'guarantorables';

    use HasFactory;

    protected $guarded = [''];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loans()
    {
        return $this->morphedByMany(Loan::class, 'guarantorable')->withPivot('remarks', 'status');
    }
}
