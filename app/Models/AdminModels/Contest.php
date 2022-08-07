<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $table = 'contest';
    protected $fillable = ['name','content', 'form_date', 'to_date', 'terms','image','button_name' ,'active'];

    public function dines()
    {
        return $this->hasMany('App\Models\AdminModels\ContestDine','contest_id')->where('type',1);
    }
    public function fc_outlets()
    {
        return $this->hasMany('App\Models\AdminModels\ContestDine','contest_id')->where('type',0);
    }

    public function participants()
    {
    	return $this->hasMany('App\Models\AdminModels\ContestParticipate','contest_id');
    }


    public function thresholdDetails()
    {
        return $this->hasMany('App\Models\AdminModels\ContestThreshold','contest_id')->where('active',1)->orderBy('percentage','ASC');
    }
}
