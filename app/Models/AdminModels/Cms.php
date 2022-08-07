<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $table = 'cms';
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_desc', 'meta_keyword', 'meta_image', 'content', 'image', 'post_time', 'active', 'header'];
}
