<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $table = 'map';
    protected $fillable = ['image', 'floor', 'active','title'];

}
