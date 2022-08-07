<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Refferal extends Model
{
    protected $table = 'referral';
    protected $fillable = ['user_id','new_user_id'];
}
