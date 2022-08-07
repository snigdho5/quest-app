<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model
{
    protected $table = 'admin_module';
    protected $fillable = ['show_menu', 'module','parent_id','icon','access_type','link','priority','active'];

    public function parent()
    {
        return $this->belongsTo('App\Models\AdminModels\AdminModule','parent_id');
    }

    public function scopeResetOrder($query,$order,$parent){
		return static::where([['priority','>', $order],['parent_id',$parent]])
		->decrement('priority',1);
	}
}
