<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
    protected $fillable = ['link','link_open', 'image', 'sq_image', 'priority', 'post_time', 'active'];



    public function scopeResetOrder($query,$order){
		return static::where('priority','>', $order)
		->decrement('priority',1);
	}
}
