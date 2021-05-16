<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
