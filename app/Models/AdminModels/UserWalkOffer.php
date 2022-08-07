<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class UserWalkOffer extends Model
{
    protected $table = 'user_walk_offer';
    protected $fillable = ['user_id', 'offer', 'image', 'offer_id', 'threshold', 'code', 'redeem_date', 'redeem_within', 'used_date', 'store_id'];
    protected $dates = ['redeem_date','used_date'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }

}
