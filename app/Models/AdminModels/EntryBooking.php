<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class EntryBooking extends Model
{
    protected $table = 'entry_booking';
    protected $fillable = ['user_id', 'entry_hash', 'date', 'slot', 'slot_id', 'child', 'status' , 'slot_start', 'slot_end', 'event_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','user_id');
    }

}
