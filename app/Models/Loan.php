<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['start_date', 'end_date'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function batchEntries()
    {
        return $this->morphMany(BatchEntry::class, 'batchable');
    }

    public function fund()
    {
    	return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function receivers()
    {
        return $this->morphMany(Receive::class, 'receiveable');
    }

    public function guarantors()
    {
        return $this->morphToMany(User::class, 'guarantorable')->withPivot('remarks', 'status');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function approvals()
    {
        return $this->morphToMany(User::class, 'approveable')->withPivot('remark', 'status');
    }

    public function trails()
    {
        return $this->morphMany(Trail::class, 'trailable');
    }

    public function payments()
    {
        return $this->morphMany(Pay::class, 'payable');
    }
}
