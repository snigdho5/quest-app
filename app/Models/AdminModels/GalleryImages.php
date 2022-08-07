<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class GalleryImages extends Model
{
    protected $table = 'gallery_img';
    protected $fillable = ['image', 'gallery_id', 'active'];

    public function gallery()
    {
        return $this->belongsTo('App\Models\AdminModels\Gallery','gallery_id');
    }
}
