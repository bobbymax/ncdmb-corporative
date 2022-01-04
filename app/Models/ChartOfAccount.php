<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function accountCode()
    {
        return $this->belongsTo(AccountCode::class, 'account_code_id');
    }
}
