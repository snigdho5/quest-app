<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oraCon extends Model
{
    //
    protected $connection = 'oracle';
    protected $table = 'VW_HW_DEVICE_DETAILS';
}
