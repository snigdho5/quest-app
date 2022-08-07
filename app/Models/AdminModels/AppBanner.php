<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class AppBanner extends Model
{
    protected $table = 'app_banner';
    protected $fillable = ['image', 'priority','page', 'active','url', 'action'];



    public function scopeResetOrder($query,$order){
		return static::where('priority','>', $order)
		->decrement('priority',1);
	}
}
