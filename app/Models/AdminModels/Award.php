<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $table = 'award';
    protected $fillable = ['title', 'image', 'category', 'organiser', 'date', 'venue', 'active'];
}
