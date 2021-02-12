<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
