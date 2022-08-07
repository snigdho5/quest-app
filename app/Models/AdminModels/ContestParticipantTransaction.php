<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class ContestParticipantTransaction extends Model
{
    protected $table = 'contest_participant_transaction';
    protected $fillable = ['participant_id', 'dine_id', 'thresehold_id', 'unique_code','percentage','trans_amount','trans_date', 'type'];

    public function participantDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\ContestParticipate','participant_id');
    }

    public function thresholdDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\ContestThreshold','thresehold_id');
    }

    public function dineDetails()
    {
    	return $this->belongsTo('App\Models\AdminModels\Store','dine_id');
    }
}
