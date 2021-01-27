<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function loans()
    {
    	return $this->morphedByMany(Loan::class, 'guarantorable')->withPivot('remarks', 'status');
    }
}
