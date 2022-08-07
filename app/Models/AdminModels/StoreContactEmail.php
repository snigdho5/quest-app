<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class StoreContactEmail extends Model
{
    protected $table = 'store_contactemail';
    protected $fillable = ['store_id', 'email','primary'];

    
}
