<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class ContestThreshold extends Model
{
    protected $table = 'contest_threshold';
    protected $fillable = ['contest_id','percentage','content','max_discount','min_trans','active','type'];

     public function contestDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\Contest','contest_id');
    }
}
