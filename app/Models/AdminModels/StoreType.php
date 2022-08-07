<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    protected $table = 'store_type';
    protected $fillable = ['title', 'type', 'active'];

    public function stores()
    {
        return $this->hasMany('App\Models\AdminModels\Store','type_id');
    }
}
