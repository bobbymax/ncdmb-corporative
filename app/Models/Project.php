<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Project"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="agent_id", type="integer", example="Agent ID"),
 * @OA\Property(property="code", type="string", example="Project CODE"),
 * @OA\Property(property="title", type="string", example="Project Title"),
 * @OA\Property(property="label", type="string", example="Project label"),
 * @OA\Property(property="path", type="string", example="Proect path"),
 * @OA\Property(property="description", type="string", example="Project Description"),
 * @OA\Property(property="start_date", type="date", example="2020-10-20"),
 * @OA\Property(property="end_date", type="date", example="2020-10-20"),
 * @OA\Property(property="amount", type="number", format="double",example="4949494.49"),
 * @OA\Property(property="timeline", type="integer", example="5"),
 * @OA\Property(property="status", type="string", enum={"pending", "in-progress", "in-review", "verified", "completed"}, example="completed"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Project
 *
 */
class Project extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $dates = ['start_date', 'end_date'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function vendor()
    {
    	return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function images()
    {
    	return $this->morphMany(Image::class, 'imageable');
    }

    public function payments()
    {
        return $this->morphMany(Pay::class, 'payable');
    }
}
