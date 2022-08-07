<?php

namespace App\Models\AdminModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	use Notifiable;

	protected $table = 'admin';
	protected $dates = ['last_login'];
    protected $fillable = [
        'name', 'username', 'password', 'role', 'last_login', 'active'
    ];
    public $timestamps = false;

    public function role_data()
    {
        return $this->belongsTo('App\Models\AdminModels\AdminType','role');
    }


}
