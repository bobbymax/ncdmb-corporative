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

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
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
        return $this->morphyToMany(User::class, 'approveable')->withPivot('remark', 'status');
    }
}
