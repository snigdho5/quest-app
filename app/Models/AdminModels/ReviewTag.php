<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class ReviewTag extends Model
{
    protected $table = 'review_tag';
    protected $fillable = ['title','active'];

}
