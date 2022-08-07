<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class EntrySettings extends Model
{
    protected $table = 'entry_setting';
    protected $fillable = ['reminder_before','terms','active','slot_limit'];
}
