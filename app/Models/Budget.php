<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $dates = ['start', 'end'];

    public function getRouteKeyName()
    {
    	return 'code';
    }

    public function expenditures()
    {
    	return $this->hasMany(Expenditure::class);
    }
}
