<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $table = 'navigation';
    protected $fillable = ['menu','parent_id','link','priority','active'];

    public function parent()
    {
        return $this->belongsTo('App\Models\AdminModels\Navigation','parent_id');
    }

    public function scopeResetOrder($query,$order,$parent){
		return static::where([['priority','>', $order],['parent_id',$parent]])
		->decrement('priority',1);
	}
}
