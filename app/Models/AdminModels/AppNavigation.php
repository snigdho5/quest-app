<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class AppNavigation extends Model {
	protected $table = 'app_navigation';
	protected $fillable = ['title','priority','page', 'active','url', 'action','icon','new'];

	public function scopeResetOrder($query, $order, $parent) {
		return static::where([['priority', '>', $order]])
			->decrement('priority', 1);
	}
}
