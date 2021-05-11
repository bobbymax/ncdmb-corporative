<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function budgetHead()
    {
    	return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }
}
