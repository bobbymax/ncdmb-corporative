<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function expenditures()
    {
        return $this->hasMany(Disbursement::class);
    }
}
