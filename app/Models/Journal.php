<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function accountType()
    {
        return $this->belongsTo(AccountCode::class, 'account_code_id');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'chart_of_account_id');
    }

    public function budgetHead()
    {
        return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
