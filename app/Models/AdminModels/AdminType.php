<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class AdminType extends Model
{
    protected $table = 'admin_type';
    protected $fillable = ['title','module','access_type','active'];
}
