<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Qreview extends Model
{
    protected $table = 'qreview';
    protected $fillable = ['title', 'slug', 'author','rating','tags', 'meta_title', 'meta_desc', 'meta_keyword', 'meta_image', 'content', 'image', 'sq_image', 'post_time', 'active'];

    
    public function authorArray()
    {
        return $this->belongsTo('App\Models\AdminModels\Qauthor','author');
    }


    public function tagArray()
    {
        return $this->belongsTo('App\Models\AdminModels\ReviewTag','tags');
    }


    public function gallery()
    {
        return $this->hasMany('App\Models\AdminModels\QreviewGallery','q_id');
    }
   
}
