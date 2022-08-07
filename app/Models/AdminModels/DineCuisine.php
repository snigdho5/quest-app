<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class DineCuisine extends Model
{
    protected $table = 'cuisine';
    protected $fillable = ['title', 'active'];
}
