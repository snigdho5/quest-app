<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    protected $table = 'event_gallery';
    protected $fillable = ['event_id', 'designer_id', 'image', 'title', 'active'];

    public function event()
    {
        return $this->belongsTo('App\Models\AdminModels\Event','event_id');
    }
}
