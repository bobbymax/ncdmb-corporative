<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCategory extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function head()
    {
    	return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }

    public function loans()
    {
    	return $this->hasMany(Loan::class);
    }
}
