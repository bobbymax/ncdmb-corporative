<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    // protected $table = "pays";

    public function getRouteKeyName()
    {
    	return 'trxRef';
    }

    public function payable()
    {
    	return $this->morphTo();
    }

    public function beneficiary()
    {
    	return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function initiator()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
