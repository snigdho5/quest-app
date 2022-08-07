<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class QreviewGallery extends Model
{
    protected $table = 'qreview_gallery';
    protected $fillable = ['q_id', 'image', 'title', 'priority', 'active'];

    public function qreview()
    {
        return $this->belongsTo('App\Models\AdminModels\Qreview','q_id');
    }

    public function scopeResetOrder($query,$order,$parent){
		return static::where([['priority','>', $order],['q_id',$parent]])
		->decrement('priority',1);
	}
}
