<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getRouteKeyName()
    {
    	return 'code';
    }

    public function budget()
    {
    	return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }
}
