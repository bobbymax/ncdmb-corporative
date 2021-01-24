<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'identifier';
    }

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
