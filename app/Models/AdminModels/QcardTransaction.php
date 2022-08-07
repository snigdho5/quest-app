<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class QcardTransaction extends Model
{
    protected $table = 'qcard_transaction';
    protected $fillable = ['user_id','type','amount','balance','store_id','source','bank_trans_id'];
}
