<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreAppDealDayTime extends Model
{
    protected $table = 'app_offer_daytime';
    protected $fillable = ['offer_id', 'day', 'fromtime', 'totime'];
    public $timestamps = false;
    
    public function deal()
    {
        return $this->belongsTo('App\Models\AdminModels\StoreAppDeal','offer_id');
    }
}
