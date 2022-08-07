<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class ContestParticipate extends Model
{
    protected $table = 'contest_participate';
    protected $fillable = ['user_id','contest_id', 'unique_code', 'participation_date', 'active'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','user_id');
    }

    public function contestDetails()
    {
        return $this->belongsTo('App\Models\AdminModels\Contest','contest_id');
    }

    public function transactions()
    {
    	return $this->hasMany('App\Models\AdminModels\ContestParticipantTransaction','participant_id');
    }


}
