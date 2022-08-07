<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class FashionPost extends Model
{
    protected $table = 'fashion_post';
    protected $fillable = ['store_id', 'title', 'image', 'tag', 'link', 'post_time', 'active'];

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }
}
