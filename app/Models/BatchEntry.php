<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="BatchEntry"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="batch_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="batchable_id", type="integer", readOnly="true", example="1"),
  * @OA\Property(property="batchable_type", type="string", readOnly="true", example="Batchable Type"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class BatchEntry
 *
 */
class BatchEntry extends Model
{
    use HasFactory;

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function batchable()
    {
        return $this->morphTo();
    }
}
