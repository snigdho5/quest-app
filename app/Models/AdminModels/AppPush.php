<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class AppPush extends Model
{
    protected $table = 'app_push';
    protected $fillable = ['title', 'body', 'subtext', 'type', 'image', 'activity', 'push', 'push_id', 'push_time','action','url'];
    protected $dates = ['push_time'];
}
