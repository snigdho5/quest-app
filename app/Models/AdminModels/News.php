<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title', 'link', 'post_time', 'active'];

}
