<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['due'];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

}
