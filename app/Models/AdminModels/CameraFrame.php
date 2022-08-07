<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class CameraFrame extends Model
{
    protected $table = 'camera_frame';
    protected $fillable = ['image','active'];
}
