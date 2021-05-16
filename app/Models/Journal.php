<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function accountType()
    {
        return $this->belongsTo(AccountCode::class);
    }

    public function entries()
    {
        return $this->morphMany(Entry::class, 'entryable');
    }
}
