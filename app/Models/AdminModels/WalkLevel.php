<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class WalkLevel extends Model
{
    protected $table = 'walk_level';
    protected $fillable = ['type','threshold'];
}
