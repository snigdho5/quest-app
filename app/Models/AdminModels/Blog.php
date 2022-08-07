<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $fillable = ['title', 'slug', 'category_id','store_id', 'meta_title', 'meta_desc', 'meta_keyword', 'meta_image', 'content', 'image', 'sq_image', 'post_time', 'active'];
    public function category()
    {
        return $this->belongsTo('App\Models\AdminModels\BlogCategory','category_id');
    }
}
