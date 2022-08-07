<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';
    protected $fillable = ['title', 'active'];
}
