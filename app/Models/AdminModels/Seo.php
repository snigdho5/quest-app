<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'link_data';
    protected $fillable = ['link', 'code', 'meta_title', 'meta_desc', 'meta_keyword', 'image', 'active'];
}
