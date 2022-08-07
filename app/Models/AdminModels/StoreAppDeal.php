<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreAppDeal extends Model
{
    protected $table = 'app_offer';
    protected $fillable = ['store_id', 'title', 'description', 'start_date', 'end_date', 'active'];
    protected $dates = ['start_date','end_date'];

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }

    public function activeday()
    {
        return $this->hasMany('App\Models\AdminModels\StoreAppDealDayTime','offer_id');
    }
}
