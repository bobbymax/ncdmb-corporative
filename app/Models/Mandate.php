<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    use HasFactory;

    public function mandateable()
    {
        return $this->morphTo();
    }
}
