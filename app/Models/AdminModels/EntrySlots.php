<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class EntrySlots extends Model
{
    protected $table = 'entry_slot';
    protected $fillable = ['slot_start', 'slot_end', 'active'];

    public function bookings()
    {
        return $this->hasMany('App\Models\AdminModels\EntryBooking','slot_id');
    }

}
