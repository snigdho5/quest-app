<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class ContestDine extends Model
{
    protected $table = 'contest_dine';
    protected $fillable = ['contest_id','dine_id', 'type'];

    public function dineDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\Store','dine_id')->select('name','id','logo');
    }

    public function contestDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\Contest','contest_id')->select('name','id');
    }
}
