<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table = 'store_category';
    protected $fillable = ['title', 'type', 'active'];
}
