<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreRating extends Model
{
    protected $table = 'storerating';
    protected $fillable = ['store_id','user_id','rate','message','approve'];
}
