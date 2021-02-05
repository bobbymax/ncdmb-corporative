<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    public $guarded = [''];

    public function transactions()
    {
    	return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
