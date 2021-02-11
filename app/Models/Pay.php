<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    public function payable()
    {
    	return $this->morphTo();
    }

    public function beneficiary()
    {
    	return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }
}
