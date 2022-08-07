<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $dates = ['last_login'];
    protected $fillable = [
        'name', 'email', 'phone', 'image', 'step_data','total_steps', 'login_device', 'platform', 'password', 'chash', 'fhash', 'token', 'last_login', 'bookmark', 'interest', 'active','blocked','referral_code', 'apple_user_id'
    ];
    public $timestamps = false;


    public function contest()
    {
    	return $this->hasMany('App\Models\AdminModels\ContestParticipate','user_id');
    }

     public function contestTransaction()
    {
        return $this->hasMany('App\Models\AdminModels\ContestParticipantTransaction','user_id');
    }

}
