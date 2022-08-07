<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreContactNo extends Model
{
    protected $table = 'store_contactno';
    protected $fillable = ['store_id', 'phone','primary'];

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }

    
}
