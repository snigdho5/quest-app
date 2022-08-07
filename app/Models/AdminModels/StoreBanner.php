<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreBanner extends Model
{
    protected $table = 'store_banner';
    protected $fillable = ['store_id', 'image','app_image', 'title', 'featured', 'priority', 'active'];

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }

    public function scopeResetOrder($query,$order,$parent){
		return static::where([['priority','>', $order],['store_id',$parent]])
		->decrement('priority',1);
	}
}
