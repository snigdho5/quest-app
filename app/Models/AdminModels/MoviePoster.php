<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class MoviePoster extends Model
{
    protected $table = 'movie_poster';
    protected $fillable = ['title', 'image', 'link', 'priority', 'active'];


	public function scopeResetOrder($query,$order){
		return static::where('priority','>', $order)
		->decrement('priority',1);
	}
}
