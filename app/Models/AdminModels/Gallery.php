<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $fillable = ['title','slug', 'date', 'active'];
    protected $dates = ['date'];

    public function images()
    {
        return $this->hasMany('App\Models\AdminModels\GalleryImages','gallery_id');
    }
}
