<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'label';
    }

//    public function expenditure()
//    {
//    	return $this->hasOne(Expenditure::class, 'category_id');
//    }

//    public function services()
//    {
//        return $this->hasMany(Service::class);
//    }

//    public function loans()
//    {
//        return $this->hasMany(Loan::class);
//    }

//    public function transactions()
//    {
//        return $this->morphMany(Transaction::class, 'transactionable');
//    }
}
