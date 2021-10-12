<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetHead extends Model
{
    use HasFactory;

    protected $guarded = [''];

    // public function getRouteKeyName()
    // {
    // 	return 'code';
    // }

    public function budget()
    {
    	return $this->belongsTo(Budget::class, 'budget_id');
    }

    // public function fund()
    // {
    //     return $this->hasOne(Fund::class, 'budget_head_id');
    // }

    public function fund($yr)
    {
        return $this->funding->where('year', $yr)->first();
    }

    public function funding()
    {
        return $this->hasMany(Fund::class, 'budget_head_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
