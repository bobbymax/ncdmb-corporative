<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Batch"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="code", type="status", readOnly="true", example="dsf6"),
 * @OA\Property(property="status", type="string", enum={"registered", "in-progress", "completed"}, example="in-progress"),
 * @OA\Property(property="closed", type="boolean",  example="true"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Batch
 *
 */
class Batch extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function entries()
    {
        return $this->hasMany(BatchEntry::class);
    }
}
