<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'query';
    protected $fillable = ['status'];
}
