<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Qauthor extends Model
{
    protected $table = 'qauthor';
    protected $fillable = ['title','content','active'];

}
