<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactee extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction()
    {
    	return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
