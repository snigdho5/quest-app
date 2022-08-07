<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    protected $table = 'beacon';
    protected $fillable = ['uuid', 'mac', 'type', 'place'];
}
