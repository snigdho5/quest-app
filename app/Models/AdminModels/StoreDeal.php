<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreDeal extends Model
{
    protected $table = 'store_deal';
    protected $fillable = ['store_id','beacon_type', 'title', 'description', 'image', 'start_date', 'end_date', 'post_time', 'active'];
    protected $dates = ['start_date','end_date'];
    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }
}
