<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemDetails extends Model
{
    //
    
    protected $primaryKey = "docket_no";
    public function solution()
    {
        return $this->belongsToMany('app\Solution');
    }
}
