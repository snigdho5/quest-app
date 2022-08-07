<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class LoftDesigner extends Model
{
    protected $table = 'designer';
    protected $fillable = ['name', 'about', 'image', 'active'];
}
