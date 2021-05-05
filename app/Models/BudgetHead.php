<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetHead extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'code';
    }

    public function budget()
    {
    	return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function fund()
    {
        return $this->hasOne(Fund::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
