<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    public function loans()
    {
        return $this->morphedByMany(Loan::class, 'approveable')->withPivot('remark', 'status');
    }
}
