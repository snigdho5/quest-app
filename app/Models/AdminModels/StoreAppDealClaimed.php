<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreAppDealClaimed extends Model
{
    protected $table = 'app_offer_claimed';
    protected $fillable = ['user_id', 'store_id', 'offer_id', 'offer_title', 'code', 'claimed', 'amount', 'staff_id', 'staff_name','staff_phone'];

    public function staff()
    {
        return $this->belongsTo('App\Models\AdminModels\StoreStaff','staff_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Models\AdminModels\StoreAppDeal','offer_id');
    }
}
