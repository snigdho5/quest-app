<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class WalkOffer extends Model
{
    protected $table = 'walk_offer';
    protected $fillable = ['offer', 'image', 'start_date','redeem_within', 'threshold', 'code', 'active', 'store_id'];
    protected $dates = ['start_date'];

    public function get_threshold()
    {
        return $this->belongsTo('App\Models\AdminModels\WalkLevel','threshold');
    }
}
