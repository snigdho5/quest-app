<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = ['name', 'email', 'mobile', 'user_id', 'store_id', 'for', 'floor', 'reason', 'feedback', 'type'];
}
