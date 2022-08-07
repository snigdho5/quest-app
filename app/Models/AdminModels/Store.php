<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $fillable = ['name', 's_type', 'type_id', 'category_id', 'beacon_id', 'floor', 'description', 'manager', 'timing', 'manager_phone', 'website', 'tags', 'logo', 'location', 'cuisine', 'menu', 'review', 'meta_title', 'meta_desc', 'meta_keyword', 'meta_image', 'post_time', 'active', 'login_id'];

    public function type()
    {
        return $this->belongsTo('App\Models\AdminModels\StoreType','type_id');
    }

    public function banner()
    {
        return $this->hasMany('App\Models\AdminModels\StoreBanner','store_id');
    }

    public function deals()
    {
        return $this->hasMany('App\Models\AdminModels\StoreDeal','store_id');
    }

    public function app_deals()
    {
        return $this->hasMany('App\Models\AdminModels\StoreAppDeal','store_id');
    }

    public function contactno()
    {
        return $this->hasMany('App\Models\AdminModels\StoreContactNo','store_id');
    }


    public function contactemail()
    {
        return $this->hasMany('App\Models\AdminModels\StoreContactEmail','store_id');
    }
    
}
