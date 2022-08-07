<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $fillable = ['title', 'slug', 'designers', 'meta_title', 'meta_desc', 'meta_keyword', 'meta_image', 'type', 'content', 'image', 'sq_image','start_date','end_date', 'post_time', 'active'];
    protected $dates = ['start_date','end_date'];
    public function banner()
    {
        return $this->hasMany('App\Models\AdminModels\EventGallery','event_id');
    }
}
