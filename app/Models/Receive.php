<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function receiveable()
    {
        return $this->morphTo();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
