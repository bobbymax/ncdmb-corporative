<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['date_acquired', 'expiry_date'];

    public function getRouteKeyName()
    {
    	return 'label';
    }

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    public function specifications()
    {
    	return $this->hasMany(Specification::class);
    }
}
