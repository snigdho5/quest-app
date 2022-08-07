<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class LoftBanner extends Model
{
    protected $table = 'loft_banner';
    protected $fillable = ['image', 'app_image', 'priority', 'active'];



    public function scopeResetOrder($query,$order){
		return static::where('priority','>', $order)
		->decrement('priority',1);
	}
}
