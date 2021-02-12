<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function beneficiary()
    {
        return $this->morphOne(Beneficiary::class, 'beneficiaryable');
    }
}
