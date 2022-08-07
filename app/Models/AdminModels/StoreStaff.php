<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreStaff extends Model
{
    protected $table = 'store_staff';
    protected $fillable = ['name', 'phone', 'store_id', 'token', 'active'];

    public function store()
    {
        return $this->belongsTo('App\Models\AdminModels\Store','store_id');
    }
}
