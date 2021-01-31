<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['due_date'];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function transactees()
    {
        return $this->hasMany(Transactee::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}
